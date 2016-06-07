<?php
/**
 * @author JKetelaar
 */

namespace JKetelaar\Redkiwi\WordPress\LocalConfig;

class Core extends \WP_CLI_Command {

    private $constants = [
        'WP_ROOT_URL'       => 'http://dev.domain.com',
        'WP_HOME'           => '%WP_ROOT_URL%',
        'WP_SITEURL_APPEND' => '/wp',
        'DB_NAME'           => '',
        'DB_USER'           => '',
        'DB_PASSWORD'       => '',
        'DB_HOST'           => 'localhost',
        'WP_CACHE'          => 'false'
    ];

    private $args;
    private $assoc_args;

    /**
     * @var string Path of execution
     */
    private $path;

    /**
     * @var string Local config file (to be created?)
     */
    private $file;

    /**
     * Core constructor.
     *
     * @param $args
     * @param $assoc_args
     */
    public function __construct( $args = null, $assoc_args = null ) {
        $this->assignArgs( $args, $assoc_args );
    }

    private function assignArgs( $args, $assoc_args ) {
        $this->args       = $args;
        $this->assoc_args = $assoc_args;

        $this->path = getcwd();
    }

    /**
     * Creates a local config
     *
     * ## OPTIONS
     *
     * [--file=<file>]
     * : The name of the local config file
     *
     * [--fields=<fields>]
     * : Extra fields to be added to the config, separated with comma's
     *
     * [--lowercase_fields]
     * : Extra fields to be added to the config, separated with comma's
     *
     * ## EXAMPLES
     *
     *     wp local-config create
     *
     * @when before_wp_load
     */
    public function create( $args, $assoc_args ) {
        $this->assignArgs( $args, $assoc_args );
        if ( $this->exists() ) {
            \WP_CLI::error( 'Seems like there\'s already a local config', false );
            \WP_CLI::error( 'You can define a specific local file using --file=file_name.php' );
        } else {
            $content = '<?php' . "\n";

            if ( isset( $this->assoc_args['fields'] ) ) {
                foreach ( explode( ',', str_replace( ' ', '', $this->assoc_args['fields'] ) ) as $field ) {
                    if ( ! isset( $this->assoc_args['lowercase_fields'] ) || $this->assoc_args['lowercase_fields'] !== true ) {
                        $field = strtoupper( $field );
                    }
                    $this->constants[ $field ] = '';
                }
            }

            foreach ( $this->constants as $key => $value ) {
                if ( self::endsWith( $value, '%' ) && self::startsWith( $value, '%' ) ) {
                    $replacement             = $this->constants[ str_replace( '%', '', $value ) ];
                    $this->constants[ $key ] = $replacement;
                    $value                   = $replacement;
                }

                $result                  = \cli\prompt( 'Value for ' . $key, $value );
                $this->constants[ $key ] = $result;
            }

            foreach ( $this->constants as $key => $value ) {
                $content .= 'define( \'' . $key . '\', \'' . $value . '\');' . "\n";
            }

            $fp = fopen( $this->path . '/' . $this->file, 'wb' );
            fwrite( $fp, $content );
            fclose( $fp );
        }
    }

    private function exists() {
        $file = 'wp-config-local.php';
        if ( ! empty( $this->assoc_args['file'] ) ) {
            $file = $this->assoc_args['file'];
        }

        $this->file = $file;

        return file_exists( $this->path . '/' . $file );
    }

    public static function endsWith( $haystack, $needle ) {
        return $needle === "" || ( ( $temp = strlen( $haystack ) - strlen( $needle ) ) >= 0 && strpos( $haystack, $needle, $temp ) !== false );
    }

    public static function startsWith( $haystack, $needle ) {
        return $needle === "" || strrpos( $haystack, $needle, - strlen( $haystack ) ) !== false;
    }
}

\WP_CLI::add_command( 'local-config', __NAMESPACE__ . '\\Core' );
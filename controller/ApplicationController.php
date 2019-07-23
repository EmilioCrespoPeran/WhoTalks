<?php
namespace controller;

require_once PATH_APP."/vendor/autoload.php";

require_once PATH_APP . "/controller/ViewController.php";
require_once PATH_APP . "/controller/RoutingController.php";
require_once PATH_APP . "/controller/ExceptionController.php";

/**
 * Controlador principal de la aplicación.
 */
class ApplicationController {

    // Variables para el routing, excepciones y vistas de la aplicacion

    private static $context;
    private $template;
    private $routing;
    private $exception;

    /**
     * Constructor de la clase
     */
    private function __construct() {
        $template_engine = $this->load_template_engine();

        $this->template = new \controller\ViewController($template_engine);
        $this->routing = new \controller\RoutingController();
        $this->exception = new \controller\ExceptionController($this->template);
    }


    public static function getApplicationContext () {
        if (self::$context == null) {
            self::$context = new \controller\ApplicationController();
        }

        return self::$context;
    }


    private function load_template_engine() {
        $loader = new \Twig\Loader\FilesystemLoader(PATH_APP."/view/");
        $twig = new \Twig\Environment($loader, array(
            'cache' => false,
        ));
        // Añade una funcion a Twig llamada 'asset' para localizar el directorio recursos
        $twig->addFunction(new \Twig\TwigFunction('asset', function ($asset) {
            return sprintf(URL_ROOT.'resources/%s', ltrim($asset, '/'));
        }));

        return $twig;
    }


    /**
     * Lee la ruta actual y ejecuta el controller y metodo correspondiente.
     * Si la ruta no existe, manda un mensaje de error.
     */
    public function init() {
        $result = self::$context->routing->get_controller_function();

        if($result == null) {
            $this->error('La página solicitada no se encuentra disponible');
        }
        else {
            $this->execute($result);
        }
    }

    /**
     * Ejecuta un metodo de la clase controller
     * @param string $controlador clase de tipo controller
     * @param string $metodo metodo del controller
     */
    private function execute($param) {
        $controller = $param['controller'];
        $function = $param['function'];
        $anonimous = isset($param['anonimous'])? $param['anonimous'] : false;

        $controller_file = PATH_APP. "/controller/". $controller ."Controller.php";
        $controller_class = "\\controller\\". $controller ."Controller";

        if (file_exists($controller_file)) {
            // Incluye el fichero para poder ser instanciado
            require_once $controller_file;
            $class = new $controller_class();

            // Ejecuta el metodo del controller si existe
            if (method_exists($class, $function)) {
                if (isset($_SESSION['username']) || $anonimous) {
                    $class->$function();
                }
                else {
                    $this->redirect("/login/");
                }
            }
            else {
                // No existe el metodo de ese controller
                $this->error("El metodo a ejecutar no existe");
            }
        }
        else {
            // No existe el controller
            $this->error("El controlador a ejecutar no existe");
        }
    }



    protected function redirect($uri) {
        $route = self::$context->routing->get_full_route($uri);
        header("Location: ". $route, true, 301);
        exit();
    }

    protected function response($view, $data = array()) {
        self::$context->template->display($view, $data);
    }

    protected function error($message) {
        self::$context->exception->display_error($message);
    }
}




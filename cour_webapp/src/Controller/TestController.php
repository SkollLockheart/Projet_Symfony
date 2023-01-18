<?php
    namespace App\Controller;
    
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class TestController{
    
        public function sayHello():Response{
            return new Response("<h1>Bonjour</h1>");
        }

        public function sayHelloUtil($name):Response{
            return new Response("<h1>Bonjour ".$name."</h1>");
        }
        /**
         * @Route ("/hello")
        */
        public function sayHello2():Response{
            return new Response("<h1>Hello</h1>");
        }
    }
?> 
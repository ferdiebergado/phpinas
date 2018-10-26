<?php
return [
    ['GET', '/hello/{name}', ['HomeController', 'index']],
    ['POST', '/auth/login', ['AuthController', 'login']]
];

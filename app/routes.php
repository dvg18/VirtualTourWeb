<?php
// Routes
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;

//сохранить диалог
/*
$app->post('/chat', function ($request, $response) {
    $json_data = $request->getParsedBody();
    $visitor = $json_data['visitor'];
    $user = $json_data['user'];
    $messages = $json_data['messages'];

    try {
        //сохраняем сообщения
        $query = $this->db->prepare("
          INSERT INTO VisitorMessage (date, text, user_id, site_id)
          VALUES (:date, :text, :user_id, :site_id);
        ");

        //VisitorMessage (date) - дата первого сообщения
        $dt = new DateTime($messages[0]['datetime']); //получаем дату первого сообщения и конвертим дату в DateTime
        $result_dt = $dt->format('Y-m-d H:i:s'); //затем конвертим в формат даты MySql
        $text = json_encode($json_data);

        //типа заглушка, пока нет site_id
        $site = "1";

        $query->bindParam("date", $result_dt);
        $query->bindParam("user_id", $user['id']);
        $query->bindParam("text", $text);
        $query->bindParam("site_id", $site);

        $query->execute();

        $json_data = "";
        $json_data['data']['id'] = $this->db->lastInsertId();

        return $response->withJson($json_data);
    } catch (Exception $e) {
        $json_data = "";
        $json_data['error']['code'] = 404;
        $json_data['error']['message'] = "ID not found";
//        $json_data['error']['message'] = $e->getMessage(); //для себя
        return $response->withJson($json_data);
    }
});
$app->group('', function () {
    $this->get('/chat', function ($request, $response, $args) {
        // Ловим ajax запрос
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //получаем параметры запроса из заголовка
            $date_from = $_GET['date_from'];
            $date_to = $_GET['date_to'];
            $user_id = $_GET['user_id'];
//    $site_id = $_GET['site_id'];   //пока без него

//        echo $date_from. " ". $date_to. " ". $user_id ."\n";

            //$operator_WHERE будет меняться в зависимости от наличия полей фильтра
            $operator_WHERE = "WHERE user_id = :user_id AND (date BETWEEN :dt_from AND :dt_to)";
            if ($date_from == "") {
                //если не заполнили дату ОТ, присваиваем предыдущий день
                $date_from = date("Y-m-d H:i:s");
                $date_from = date("Y-m-d H:i:s", strtotime($date_from . ' -1 day'));
//            echo "\n date from: ". $date_from ."\n";
            }
            if ($date_to == "") {
                //если не заполнили дату ОТ, присваиваем текущую дату
                $date_to = date("Y-m-d H:i:s");
            }
            if ($user_id == "") {
                //если нет user_id ищем по всем user'ам
                $operator_WHERE = "WHERE date BETWEEN :dt_from AND :dt_to";
            }

            try {
                //соединяем таблицы VisitorMessage, User, Visitor. Выбираем некоторые поля.
                $query = $this->db->prepare("
              SELECT
              VisitorMessage.id AS dialog_id,
              VisitorMessage.date AS dialog_date,
              User.id AS user_id,
              User.login AS user_login,
              User.first_name AS  user_firstname,
              User.last_name AS user_lastname,
              User.info AS user_info,
              VisitorMessage.text AS text
              FROM VisitorMessage INNER JOIN User ON VisitorMessage.user_id = User.id
              " . $operator_WHERE . ";");


//            echo "select prepared \n";

                $dt_from = new DateTime($date_from);
                $dt_from = $dt_from->format('Y-m-d H:i:s');
                $query->bindParam("dt_from", $dt_from);

                $dt_to = new DateTime($date_to);
                $dt_to = $dt_to->format('Y-m-d H:i:s');
                $query->bindParam("dt_to", $dt_to);

                if ($user_id != "") {
                    $query->bindParam("user_id", $user_id);
                }

                $query->execute();

//            echo "select executed \n";

                $dialogs = $query->fetchAll();

//            echo "dialogs: \n";
//            print_r($dialogs);

                $data = [];
                foreach ($dialogs as $dialog) {
                    $t = json_decode($dialog['text'], true);
                    $temp_user['id'] = $dialog['user_id'];
                    $temp_user['login'] = $dialog['user_login'];
                    $temp_user['first_name'] = $dialog['user_firstname'];
                    $temp_user['last_name'] = $dialog['user_lastname'];
                    $temp_user['info'] = $dialog['user_info'];

                    $temp_row['id'] = $dialog['dialog_id'];
                    $temp_row['date'] = $dialog['dialog_date'];
                    $temp_row['user'] = $temp_user;
                    $temp_row['visitor'] = $t['visitor'];
                    $temp_row['text'] = $dialog['text'];
                    $data[] = $temp_row;
                }
//            echo "output data:\n";
//            print_r(json_encode($data));

                $json_data['data'] = $data;
                return json_encode($json_data);
            } catch (Exception $e) {
//            echo "ERROR filter dialogs: ". $e->getMessage();
                $json_data['error']['message'] = $e->getMessage();
                $json_data['error']['line'] = $e->getLine();
                return json_encode($json_data);
            }
        }
        //Если это не ajax запрос
        return $this->view->render($response, 'chat.twig');
    })->setName('chat');

    $this->get('/chat/{filter}', function ($request, $response, $args) {
        //в запросе приходит фильтр, он определяет какой шаблон отправляется обратно

        return $this->view->render($response, $args['filter'] . '.twig');
    });

})->add(new RoleMiddleware($container, 'owner'));
*/

/*$app->group('', function () {
    $this->get('/admin', function ($request, $response, $args) {
        return $this->view->render($response, 'chat.twig'); //временная заглушка для проверки работоспособности
    })->setName('auth.admin');
})->add(new RoleMiddleware($container, 'admin'));
*/

/*
$app->group('', function () {
    $this->get('/owner', function($request, $response, $args){
        return $this->view->render($response,  'chat.twig'); //тоже самое
    })->setName('auth.owner');
})->add(new RoleMiddleware($container, 'owner'));
*/
/*
$app->group('', function () {
    $this->get('/operator', 'OperatorController:redirectOperator')->setName('auth.operator');
*/
    /***Для работы на localhost***/
/*
    $this->get('/operator-test-page', function ($request, $response, $args) {
        return $this->view->render($response, 'collection_public.twig');
    });
*/
    /*** ***//*
})->add(new RoleMiddleware($container, 'operator'));*/


$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));

        if($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        }
        else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function () {
    $this->get('/login', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/login', 'AuthController:postSignIn');
    $this->post('/signin', 'AuthController:postSignInBasic');
})->add(new GuestMiddleware($container));


$app->group('', function () {
    $this->get('/signout', 'AuthController:getSignOut')->setName('auth.signout');
})->add(new AuthMiddleware($container));

$app->get('/signup', 'UserController:getCreate')->setName('user.create');
$app->post('/signup', 'UserController:postCreate');

$app->post('/upload', 'CollectionController:upload')->setName('collection.upload');
$app->get('/public', 'CollectionController:getPublic')->setName('collection.public');
$app->get('/public/list', 'CollectionController:publicList')->setName('collection.public.list');
$app->get('/public/{id}', 'CollectionController:show')->setName('collection.public.read');

$app->group('', function () {

    $this->get('/collection', 'CollectionController:collection')->setName('collection.all');
    $this->get('/collection/create', 'CollectionController:getCreate')->setName('collection.create');
    $this->post('/collection/create', 'CollectionController:postCreate');
    $this->get('/collection/edit/{id}', 'CollectionController:edit')->setName('collection.edit');
    $this->get('/collection/show/{id}', 'CollectionController:show')->setName('collection.show');
// api
    $this->get('/collection/list', 'CollectionController:list')->setName('collection.list');
    $this->get('/collection/{id}', 'CollectionController:read')->setName('collection.read');
    $this->put('/collection/{id}', 'CollectionController:update');
    $this->delete('/collection/{id}', 'CollectionController:delete');
})->add(new AuthMiddleware($container));

$app->group('', function () {

    $this->get('/user', 'UserController:user')->setName('user.all');
// api
    $this->get('/user/list', 'UserController:list')->setName('user.list');
    $this->get('/user/{id}', 'UserController:read');
    $this->post('/user', 'UserController:postCreate');
    $this->put('/user/{id}', 'UserController:update');
    $this->delete('/user/{id}', 'UserController:delete');
})->add(new RoleMiddleware($container, 'admin'));



/***** User CRUD *****/
//api
    //$this->get('/user/role/{id}', 'UserController:role');

//$this->get('/user/login/{id}', 'UserController:directLogin')->setName('user.direct');

    /***** ******/

    /***** Department CRUD *****/

/*    $this->get('/department/all', 'DepartmentController:readAll');
    $this->get('/department/all/{site_id}', 'DepartmentController:readSite');
    $this->get('/department', 'DepartmentController:department')->setName('department');

    $this->get('/department/create', 'DepartmentController:getCreate')->setName('department.create');
    $this->post('/department/create', 'DepartmentController:postCreate');
    $this->get('/department/list', 'DepartmentController:list')->setName('department.list');
    $this->get('/department/{id}', 'DepartmentController:read');


    $this->post('/department', 'DepartmentController:postCreate');

    $this->put('/department/{id}', 'DepartmentController:update');
    $this->delete('/department/{id}', 'DepartmentController:delete');
*/
    /***** ******/

    /**operator api**/
    //$this->get('/operators', 'OperatorController:dropdownOperator')->setName('dropdownOperator');

    /** site **//*
    $this->get('/site/create', 'SiteController:getCreate')->setName('site.create');
    $this->post('/site/create', 'SiteController:postCreate'); //<<--------------------------ЗАГЛУШКА

    $this->get('/site', 'SiteController:site')->setName('site');
    $this->get('/site/edit/{id}', 'SiteController:edit')->setName('site.edit');
    // api
    $this->get('/site/list', 'SiteController:list')->setName('site.list');
    $this->put('/site/{id}', 'SiteController:update');

    $this->get('/sites', 'SiteController:dropdownSite');*/

//})->add(new RoleMiddleware($container, 'owner'));

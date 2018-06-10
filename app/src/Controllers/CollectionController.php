<?php
/**
 * Created by PhpStorm.
 * User: reghi
 * Date: 27.10.2017
 * Time: 15:51
 */

namespace App\Controllers;

use App\Classes\Collections;
use App\Models\User;
use App\Models\UserCollection;

class CollectionController extends Controller
{
    /**
     * @var string
     */
    protected $FILES_DIRECTORY = 'tmp/images/';

    /**
     * @var int
     */
    protected $RESOLUTION = 2048;

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function upload($request, $response)
    {
        $blacklist = array(".php", ".phtml", ".php3", ".php4");

        foreach ($blacklist as $item) {
            if (preg_match("/$item\$/i", $_FILES['uploads']['name'])) {
                echo "We do not allow uploading PHP files\n";
                return;
            }
        }

        $uploadDir = 'uploads/'; // Relative path under webroot
        //$uploadFile = $uploadDir . basename($_FILES['uploads']['name']);

        $login = '';
        if (!isset($_POST['login'])) {//&& strlen($login) < 0) {
            echo 'You are not authorized';
            return;
        }
        $login = $_POST['login'];
        echo $login;

        if (!isset($_POST['name'])) {
            echo "Sorry, you didn't write name";
            return;
        }

        if (!$_FILES) {
            echo "Sorry, you didn't send file";
            return;
        }

        $imageinfo = getimagesize($_FILES["uploads"]["tmp_name"]);
        if ($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg'
            && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png') {
            echo "Sorry, we only accept GIF, PNG and JPEG images\n";
            return;
        }

        $user = User::where('login', $login)->first();
        $count = 0;

        $collection = UserCollection::where('name', $_POST['date'])->first();
        if ($collection == null) {
            $collection = UserCollection::create([
                'name' => $_POST['date'],
                'user_id' => $user->id
            ]);
        } else {
            $count = $collection->image_count;
        }
        $dir = $this->FILES_DIRECTORY . $login . '/' . $collection->id . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, TRUE);
            echo $dir . ' created';
        }
        $name = $dir . $_FILES["uploads"]["name"];
        //foreach ($_FILES["uploads"]["error"] as $key => $error) {
        if ($_FILES["uploads"]["error"] == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["uploads"]["tmp_name"];//[$key];
            //      $name = $dir . $_FILES["uploads"]["name"][$key];
            move_uploaded_file($tmp_name, "$name");
            $ratio = 1.0;
            list($width, $height) = getimagesize($name);
            if ((($width - 512) > $this->RESOLUTION) || (($height - 512) > $this->RESOLUTION)) { //не сжимаем, если разрешение больше всего на 512 точек
                if ($width > $height) {
                    $ratio = $width / $height;
                    $new_width = $this->RESOLUTION;
                    $new_height = $new_width / $ratio;
                } else {
                    $ratio = $height / $width;
                    $new_height = $this->RESOLUTION;
                    $new_width = $new_height / $ratio;
                }
                $image_p = imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefromjpeg($name);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                imagejpeg($image_p, $name, 90); //90 - это качество 0-100%
            }


            //unset($_FILES['uploads'][$key]);
            $count++;
            $collection->image_count = $count;
        }
        //}

        try {
            $collection->save();
        } catch (\Exception $e) {
            return $response->withJson(
                [
                    'error' => ['code' => $e->getCode(), 'message' => $e->getMessage()]
                ]);
        }
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function collection($request, $response, $args)
    {
        return $this->container->view->render($response, 'collection.twig');
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function show($request, $response, $args)
    {
        //$files = Collections::getFiles($args['id'], $this->FILES_DIRECTORY);

        $collection = UserCollection::findOrFail($args['id']);
        $user = User::findOrFail($collection->user_id);
        $file_path = $this->FILES_DIRECTORY . $user->login . '/' . $collection->id . '/';
        $files = array_diff(scandir($file_path), array('..', '.'));

        return $this->container->view->render($response, 'collection_show.twig', [
            'files' => $files,
            'path' => $file_path,
        ]);
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return string
     */
    public function read($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';

        $collection = UserCollection::findOrFail($args['id']);
        if ($collection->isPublic == 0) {
            $collection->isPublic = "Нет";
        } elseif ($collection->isPublic == 1) {
            $collection->isPublic = "Да";
        }
        return json_encode($collection);
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function list($request, $response, $args)
    {
        $role = $this->container->role->getUserRole();
        $user = $this->container->auth->user();
        if (empty($args['id'])) {
            if ($role->role_name === 'admin') {
                return $response->withJson(UserCollection::all());
            } else {
                $output = array();
                $collections = UserCollection::where('user_id', $user->id)->get();
                foreach ($collections as $collection) {
                    if ($collection->isPublic == 0) {
                        $collection->isPublic = "Нет";
                    } elseif ($collection->isPublic == 1) {
                        $collection->isPublic = "Да";
                    }
                    array_push($output, $collection);
                }
                return $response->withJson($output);
            }

        }
        return $response->withJson(UserCollection::findorFail($args['id']));
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function publicList($request, $response, $args)
    {
        $collections = $this->container->collection->getPublic();
        $output = array();
        foreach ($collections as $collection) {
            array_push($output, $collection);
        }
        return $response->withJson($output);
        //return $response->withJson(UserCollection::findorFail($args['id']));
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function getPublic($request, $response)
    {
        return $this->container->view->render($response, 'collection_public.twig');
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function getCreate($request, $response)
    {
        return $this->container->view->render($response, 'collection_create.twig');
    }

    /**
     * @param $request
     * @param $response
     * @return string
     */
    public function postCreate($request, $response)
    {
        $user = $this->container->auth->user();
        $collection = UserCollection::create([
            'id' => $request->getParam('id'),
            'name' => $request->getParam('name'),
            //'description' => $request->getParam('description'),
            'user_id' => $user->id,
        ]);
        return "id: " . (string)$collection['id'];
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return mixed
     */
    public function edit($request, $response, $args)
    {
        $collection = UserCollection::findOrFail($args['id']);
        return $this->container->view->render(
            $response,
            'collection/edit.twig',
            array('collection' => $collection)
        );
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return string
     */
    public function update($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';

        $collection = UserCollection::findOrFail($args['id']);
        foreach ($request->getParsedBody() as $param) {
            $collection->{$param['name']} = $param['value'];
        }
        //$department->department_id = $request->getParam('id');
        //$collection->name = $request->getParam('name');
        //$collection->isPublic = $request->getParam('isPublic');
        //$collection->description = $request->getParam('description');
        //$collection->site_id = $request->getParam('site_id');
        try {
            $collection->save();
            return $response->withJson(["data" => ["id" => $collection->id]]);
        } catch (\Exception $e) {
            return $response->withJson(
                [
                    'error' => ['code' => $e->getCode(), 'message' => $e->getMessage()]
                ]);
        }
        return (string)$collection['id'];
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return string
     */
    public function delete($request, $response, $args)
    {
        if ($args['id'] <= 0) return 'Неверный id';
        try {
            $collection = UserCollection::findOrFail($args['id']);
            $collection->delete();
        } catch (\Exception $e) {
            return $response->withJson(
                [
                    'error' => ['code' => $e->getCode(), 'message' => $e->getMessage()]
                ]);
        }
        return 'Удаление успешно';
    }

}

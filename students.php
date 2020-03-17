<?php
    $_dbHostname = "localhost:3306";
    $_dbName = "fi_itis_meucci";
    $_dbUsername = "root";
    $_dbPassword = "root";
    $_con = new PDO("mysql:host=$_dbHostname;dbname=$_dbName", $_dbUsername, $_dbPassword);
    $_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_con->exec('SET NAMES utf8');
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    switch($requestMethod)
    {
        case 'GET':
            $pathArray = explode('/',$_SERVER['REQUEST_URI']);
            if(isset($pathArray[3]))
            {
                //con parametro id
                $id = $pathArray[3];
                $sql = "select * from student where id=:id";
                $stmt = $_con->prepare($sql);
                $params = 
                [
                    'id'=>$id
                ];
                $stmt->execute($params);
                $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            else
            {
                //senza il parametro id torna tutta la tabella
                $sql = "select * from student";
                $stmt = $_con->prepare($sql);
                $stmt->execute();
                $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            $js_encode = json_encode(array($data),true);
            //output
            header('Content-Type: application/json');
            echo $js_encode;
        break;
		case 'POST':
			$json = file_get_contents('php://input');
			$data = json_decode($json,true);
			$sql = "insert into student values(default, :name, :surname, :sidiCode, :taxCode);";
			$stmt = $_con->prepare($sql);
            $params = 
            [
				'name'=>$data["name"],
				'surname'=>$data["surname"],
				'sidiCode'=>$data["sidiCode"],
				'taxCode'=>$data["taxCode"]
			];
			$stmt->execute($params);
			$sql = "select * from student where sidiCode=:sidiCode";
			$stmt = $_con->prepare($sql);
            $params = 
            [
				'sidiCode'=>$data["sidiCode"]
			];
			$stmt->execute($params);
			$data = $stmt->fetch(\PDO::FETCH_ASSOC);
			$js_encode = json_encode(array($data),true);
            header('Content-Type: application/json');
            echo $js_encode;
        break;
        case 'DELETE':
            $pathArray = explode('/',$_SERVER['REQUEST_URI']);
			$id=$pathArray[3];
			$sql = 'delete from student where id=:id';
			$stmt = $_con->prepare($sql);
            $params = 
            [
                'id'=>$id
            ];
			$stmt->execute($params);
			echo 'Cancellazione effettuata.';
		break;
		case 'PUT':
		break;
        case 'PATCH':
		break;
    }
?>
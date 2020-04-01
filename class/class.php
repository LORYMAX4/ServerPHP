<?php 
include("DBConnection.php");
class classes 
{
    protected $db;
    public $_id;
    public $_year;
    public $_section;
    public function __construct() 
    {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }
    public function insert() 
    {
        try 
        {
    		$sql = 'INSERT INTO class (year, section)  VALUES (:year, :section)';
            $data = 
            [
			    'year' => $this->_year,
			    'section' => $this->_section,
			];
	    	$stmt = $this->db->prepare($sql);
	    	$stmt->execute($data);
			$status = $stmt->rowCount();
        } 
        catch (Exception $e) 
        {
			header("HTTP/1.1 500 Internal server error");
    		die("Oh noes! There's an error in the query!".$e);
		}
        try 
        {
    		$sql = "SELECT * FROM class WHERE section=:section";
		    $stmt = $this->db->prepare($sql);
            $data =
            [
		    	'section' => $this->_section,
			];
		    $stmt->execute($data);
		    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } 
        catch (Exception $e) 
        {
			header("HTTP/1.1 500 Internal server error");
			die("Oh noes! There's an error in the query!");
		}
    }
    public function list() 
    {
        try 
        {
    		$sql = "SELECT * FROM class";
		    $stmt = $this->db->prepare($sql);
		    $stmt->execute();
		    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }
        catch (Exception $e) 
        {
		    die("Oh noes! There's an error in the query!");
		}
    }
    public function one() 
    {
        try 
        {
    		$sql = "SELECT * FROM class WHERE id=:id";
		    $stmt = $this->db->prepare($sql);
            $data = 
            [
		    	'id' => $this->_id
			];
		    $stmt->execute($data);
		    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } 
        catch (Exception $e)
        {
		    die("Oh noes! There's an error in the query!");
		}
    }
    public function delete() 
    {
        try 
        {
    		$sql = "DELETE FROM class WHERE id= :id";
		    $stmt = $this->db->prepare($sql);
            $data =
            [
		    	'id' => $this->_id
			];
		    $stmt->execute($data);
        } 
        catch (Exception $e) 
        {
			header("HTTP/1.1 500 Internal server error");
		    die("Oh noes! There's an error in the query!".$e);
		}
    }
    public function put() 
    {
        try 
        {
    		$sql = "UPDATE class SET year = :year, section = :section WHERE id = :id";
		    $stmt = $this->db->prepare($sql);
                $data = 
                [
                    'id' => $this->_id,
                    'year' => $this->_year,
                    'section' => $this->_section,
                ];
		    $stmt->execute($data);
        } 
        catch (Exception $e) 
        {
			header("HTTP/1.1 500 Internal server error");
		    die("Oh noes! There's an error in the query!".$e);
		}
    }
    public function patch() 
    {
        try 
        {
			$campi="";
            if(!is_null($this->_year) || $this->_year =! "")
            {
				$campi .= "year = :year,";
            }
            if(!is_null($this->_section) || $this->_section =! "")
            {
                $campi .= "section = :section,";
            }
			$campi = rtrim($campi,",");
    		$sql = "UPDATE class SET ".$campi." WHERE id = :id";
			$stmt = $this->db->prepare($sql);
            $data = 
            [
				'id' => $this->_id,
			];
        if(!is_null($this->_year) || $this->_year =! "")
        {
            $data['year'] = $this->_year;
        }
        if(!is_null($this->_section) || $this->_section =! "")
        {
            $data['section'] = $this->_section;
        }
		echo $sql;
		$stmt->execute($data);
		    return ;
        } 
        catch (Exception $e) 
        {
			header("HTTP/1.1 500 Internal server error");
		    die("Oh noes! There's an error in the query!".$e);
		}
    }
}
?>
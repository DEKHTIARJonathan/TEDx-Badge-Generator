<?php
 
class SPDO
{

  private $PDOInstance = null;
  private static $instance = null;
  
  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */

  const DEFAULT_SQL_HOST = '########';

/**
   * Constante: port de la bdd
   *
   * @var string
   */

  const DEFAULT_SQL_PORT = '3306';

  /**
   * Constante: nom d'utilisateur de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_USER = '############';

  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_PASS = '##############';
 
  /**
   * Constante: nom de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_DTB = '#############';
 
  /**
   * Constructeur
   *
   * @param void
   * @return void
   * @see PDO::__construct()
   * @access private
   */
  private function __construct()
  {
    try {
        $this->PDOInstance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST.';port='.self::DEFAULT_SQL_PORT,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS,  array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));       
    }
    catch ( Exception $e ) 
    {
        echo "Connection à MySQL impossible : <br>", $e->getMessage();
        //echo '<meta http-equiv="Refresh" content="5; Url='.$_CONFIG['home'].'">';
        die();
    }    
  }
 
   /**
    * Crée et retourne l'objet SPDO
    *
    * @access public
    * @static
    * @param void
    * @return SPDO $instance
    */
  public static function getInstance()
  {  
    if(is_null(self::$instance))
    {
      self::$instance = new SPDO();
    }
    return self::$instance;
  }
 
  /**
   * Exécute une requête SQL avec PDO
   *
   * @param string $query La requête SQL
   * @return PDOStatement Retourne l'objet PDOStatement
   */
  /*
  public function query($query)
  {
    return $this->PDOInstance->query($query);
  }

  */
  public function prepare($query)
  {
    return $this->PDOInstance->prepare($query);
  }
}       
?>
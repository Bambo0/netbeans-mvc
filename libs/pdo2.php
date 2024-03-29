<?php

/**
 * Classe impl&#233;mentant le singleton pour PDO
 * @author Savageman
 */

class PDO2 extends PDO {

	private static $_instance;

	/* Constructeur : h&#233;ritage public obligatoire par h&#233;ritage de PDO */
	public function __construct( ) {
	
	}
	// End of PDO2::__construct() */

	/* Singleton */
	public static function getInstance() {
	
		if (!isset(self::$_instance)) {
			
			try {
			
				self::$_instance = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
			
			} catch (PDOException $e) {
			
				echo $e;
			}
		} 
		return self::$_instance; 
	}
	// End of PDO2::getInstance() */
}

// end of file */
?>
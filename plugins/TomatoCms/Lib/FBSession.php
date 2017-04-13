<?PHP
class FBSession{

	private function FBSession(){}

	public static function isLoggedIn(){
		return ( CakeSession::read('RegisteredUser.uid') && CakeSession::read('RegisteredUser.registered') == true );
	}

	public static function logOut(){
		CakeSession::delete('RegisteredUser');
	}

	public static function get($key=null){

		if(!$key){
			return CakeSession::read('RegisteredUser');	
		}

		return CakeSession::read('RegisteredUser.' . $key);
	}

	public static function set($key, $value){
		return CakeSession::write('RegisteredUser.' . $key, $value);
	}

	public static function addFBInit($script){
		$oldScript = Configure::read('FBInit');

		$oldScript .=  $script;

		Configure::write('FBInit', $oldScript);
	}

	public static function getFBInit(){
		return Configure::read('FBInit');
	}
}
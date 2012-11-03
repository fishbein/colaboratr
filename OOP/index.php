<?php
	class myClass
	{
		//property declaration
		public $var = 'default value';
		
		//method declaration
		public function displayVar(){
			echo $this->var; //refers to line 5
		}
		const constant = 'constant value';
		
		function showConstant(){
			echo self::constant . "\n";
		}
	}
		//Ways to display the constant
		echo MyClass::constant . "<br />";	
	$class = new myClass(); //new instance of "myClass"
	
	$class->showConstant();
	echo '<br />';
	
	$class->displayVar(); //Initiate function "displayVar" in "myClass"
	echo '<br />';
	$assigned = $class;
	$reference =& $class;
	
	$class->var = '$assigned will have this value';
	$class = null; // $class and $reference become null
	
	var_dump($class); echo ' - Class<br />';
	var_dump($reference); echo ' - Reference <br />';
	var_dump($assigned); echo ' - Assigned <br /><br />';
	
//Extends
	class ExtendClass extends myClass
	{
		//redefine parent method
		function displayVar()
		{
			echo "Extending class\n";
			parent::displayVar();
		}
	}
	
	$extend = new ExtendClass();
	$extend->displayVar(); //Not only displays the original from myClass but also what we've added
	
	
	class properties{
		//DON'T DO THIS (Invalid)
		//public $var1 = 'hello '.'world';
		//public $var2 = 1+2;
		//public $var3 = self::myStaticMethod();
		//public $var4 = $myVar;
		
		//DO THIS (Valid)
		public $var5 = myConstant;
		public $var6 = array(true,false);
	}
	
	$properties = new properties();
	echo '<br /><br />';
	var_dump ($properties->var6[0]);
	
	echo '<br />';
	
	//autoload
	function __autoload($class_name){
		include $class_name . '.php';
	}
	//$obj = new myClass1(); //Tries to autoload myClass1 and include myClass1.php
	
	//Construct and Destruct
	class Login{
		function __construct($username, $password){
			print "User: $username\n Password: $password\n";
		}
		function __destruct() {
			//What happens when all class-related items are finished
       		// print "<Br />Destruction! \n";
   		}
	}
	
	$login = new Login('username', 'password');
	
	class Visibility{
		public $public = 'Public';
		protected $protected = 'Protected';
		private $private = 'Private';
		
		function printHello(){
			echo $this->public;
			echo $this->protected;
			echo $this->private;
		}
	}
	
	$visibility = new Visibility;
	echo '<br />'.$visibility->public; //Works
	//echo $visibility->protected.'<br />'; //Fatal Error (In class and children classes)
	//echo $visibility->private.'<br />'; //Fatal Error (In class only)
	$visibility->printHello(); //Shows public, protected, and private becuase it is within class
	echo '<br />';
	
	class VisiblitySub extends Visibility{
		protected $protected = 'Protected2';

    	function printHello()
    	{
        	echo $this->public;
        	echo $this->protected;
        	echo $this->private;
    	}
	}
	$visibilitysub = new VisiblitySub();
echo $visibilitysub->public; // Works
//echo $visibilitysub->private; // Undefined
//echo $visibilitysub->protected; // Fatal Error
$visibilitysub->printHello(); // Shows Public, Protected2, Undefined (private only works in base class)
/*
* NOTE: the same public, protercted, and private system works with methods
*/

class doubleColon{
	const CONST_VALUE = 'A constant value<br />';
}
echo doubleColon::CONST_VALUE; //within doubleColon

//Static Values
class Foo{
	public static $my_static = 'foo';
	
	public function staticValue() {
		return self::$my_static;
	}
}

class Bar extends Foo{
	public function fooStatic(){
		return parent::$my_static;
	}
}

print Foo::$my_static . "<br />"; //no class initiation needed

$foo = new Foo();
print $foo->staticValue() . "<br />";
print $foo->my_static . "<br />"; // BAD Undefined 'property' my_static
/*
* NOTE: Methods can also be static
*/

abstract class AbstractClass{
	//Force Extending class to define this method
	abstract protected function getValue();
	abstract protected function prefixValue($prefix);
	
	//Common Method
	public function printOut(){
		print $this->getValue()."\n";
	}
}
class ConcreteClass1 extends AbstractClass{
	protected function getValue(){
		return "ConcreteClass1";
	}
	
	public function prefixValue($prefix){
		return "{$prefix}ConcreteClass1";
	}
}
class ConcreteClass2 extends AbstractClass{
	public function getValue(){
		return "ConcreteClass2";
	}
	
	public function prefixValue($prefix){
		return "{$prefix}ConcreteClass2";
	}
}

$class1 = new ConcreteClass1;
$class1->printOut();
echo $class1->prefixValue('FOO_') . "\n";

$class2 = new ConcreteClass2;
$class2->printOut();
echo $class2->prefixValue('FOO_') . "\n";

/*
*Summary: Abstract Classes can utilize functions in post-defined classes extending it
*/
?>
<?php

/**
 * Test: Nette\Web\SessionNamespace::setExpiration()
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Web
 * @subpackage UnitTests
 */

use Nette\Web\Session;



require __DIR__ . '/../initialize.php';



ob_start();

$session = new Session;

// try to expire whole namespace
$namespace = $session->getNamespace('expire');
$namespace->a = 'apple';
$namespace->p = 'pear';
$namespace['o'] = 'orange';
$namespace->setExpiration('+ 2 seconds');

$session->close();
sleep(3);
$session->start();

$namespace = $session->getNamespace('expire');
T::dump( http_build_query($namespace->getIterator()) );

// try to expire only 1 of the keys
$namespace = $session->getNamespace('expireSingle');
$namespace->setExpiration(2, 'g');
$namespace->g = 'guava';
$namespace->p = 'plum';

$session->close();
sleep(3);
$session->start();

$namespace = $session->getNamespace('expireSingle');
T::dump( http_build_query($namespace->getIterator()) );



__halt_compiler() ?>

------EXPECT------
""

"p=plum"

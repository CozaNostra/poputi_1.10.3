<?php
/******************************************************************************/
//                                                                            //
//                             InstantCMS v1.9                                //
//                        http://www.instantcms.ru/                           //
//                                                                            //
//                   written by InstantCMS Team, 2007-2011                    //
//                produced by InstantSoft, (www.instantsoft.ru)               //
//                                                                            //
//                        LICENSED BY GNU/GPL v2                              //
//                                                                            //
/******************************************************************************/

    function routes_poputi(){


        $routes[] = array(
                            '_uri'  => '/^poputi\/v([0-9]+).html$/i',
                            'do'    => 'read_v',
                            1       => 'id'
                         );
						 
		$routes[] = array(
                            '_uri'  => '/^poputi\/published([0-9]+).html$/i',
                            'do'    => 'published',
                            1       => 'id'
                         );
		
		
		$routes[] = array(
                            '_uri'  => '/^poputi\/status([0-9]+)-([0-9]+).html$/i',
                            'do'    => 'status',
                            1       => 'id',
                            2       => 'st'
                         );
		
		$routes[] = array(
                            '_uri'  => '/^poputi\/depub([0-9]+).html$/i',
                            'do'    => 'depublished',
                            1       => 'id'
                         );
		
        $routes[] = array(
                            '_uri'  => '/^poputi\/p([0-9]+).html$/i',
                            'do'    => 'read_p',
                            1       => 'id'
                         );
						 
        $routes[] = array(
                            '_uri'  => '/^poputi\/del([0-9]+).html$/i',
                            'do'    => 'delprof',
                            1       => 'id'
                         );

        $routes[] = array(
                            '_uri'  => '/^poputi\/add.html$/i',
                            'do'    => 'add'
                         );
		
		$routes[] = array(
                            '_uri'  => '/^poputi\/edit([0-9]+).html$/i',
                            'do'    => 'edit',
							1		=> 'id'
                         );
		
		$routes[] = array(
                            '_uri'  => '/^poputi\/search$/i',
                            'do'    => 'search'
                         );
		
		$routes[] = array(
                            '_uri'  => '/^poputi\/drivers\/([0-9]+)$/i',
                            'do'    => 'drivers',
							1		=> 'page'
                         );
						 
		$routes[] = array(
                            '_uri'  => '/^poputi\/passenger\/([0-9]+)$/i',
                            'do'    => 'passenger',
							1		=> 'page'
                         );
		$routes[] = array(
                            '_uri'  => '/^poputi\/drivers$/i',
                            'do'    => 'drivers'
                         );
						 
		$routes[] = array(
                            '_uri'  => '/^poputi\/passenger$/i',
                            'do'    => 'passenger'
                         );

        return $routes;

    }

?>

<?php
    namespace Models\Kernel ;
    use \Propel\Runtime\Propel ;
    use \Propel\Runtime\Connection\ConnectionManagerSingle ;

    abstract class CoreController extends CoreApp
    {
        protected $action = null ;
        protected $module = null ;
        protected $page = null ;
        protected $view = null ;
        protected $managers = null ;
        protected $languages = array() ;
        protected $authorized = false ;
        protected $pageRestrictions = array( "object"=>array(), "field"=>array() ) ;
        protected $globalRestrictions = array() ;
        
        public function __construct( Core $app, $module, $action )
        {
            parent::__construct( $app ) ;
            
            $this->setModule( $module ) ;
            $this->setAction( $action ) ;
            $this->page = new Page( $app ) ;
            $this->setView( $action ) ;

            
            $default_database = $app->config()->get('default:database') ;
            switch( strtolower( $app->config()->get("databases:$default_database:adapter" ) ) )
            {
                case "mysql":
                    $serviceContainer = Propel::getServiceContainer();
                    $serviceContainer->setAdapterClass( 'pfw', 'mysql' ) ;
                    $manager = new ConnectionManagerSingle();
                    $manager->setConfiguration( array(
                      'dsn'      => $app->config()->get("databases:$default_database:dsn"),
                      'user'     => $app->config()->get("databases:$default_database:username"),
                      'password' => $app->config()->get("databases:$default_database:password"),
                    ) ) ;
                    $serviceContainer->setConnectionManager( 'pfw', $manager ) ;

                    /*$this->managers = new Managers( 'PDO', PDOFactory::getMysqlConnexion(   
                                                                                    $app->config()->get("databases:$default_database:dsn"),
                                                                                    $app->config()->get("databases:$default_database:username"),
                                                                                    $app->config()->get("databases:$default_database:password"),
                                                                                    $app->config()->get("databases:$default_database:settings")
                                                                                ) ) ;*/
                break;
                default:
                    throw new \Exception( "DB: Unsupported database type", 1 ) ;
                break;
            }
            
            $this->setLanguages( $app->config()->get('languages') ) ;
        }

        public function execute()
        {
            $method = 'execute'.ucfirst($this->action) ;
            
            if ( !is_callable( array( $this, $method ) ) )
                throw new \RuntimeException('RUNTIME: Undefined ACTION "'.$this->action.'"on this module') ;

            //if( $this->authorized )
                $this->$method( $this->app->httpRequest() ) ;
            /*else
            {
                $this->app->auth()->setFlash( $this->app->lang()->txt('notEnoughRights'), 2 ) ;
                $this->app->httpResponse()->redirectReferer() ;
            }*/

            //$this->page->addVar('globalRestrictions', $this->globalRestrictions ) ;
            //$this->page->addVar('pageRestrictions', $this->pageRestrictions ) ;
        }
        
        public function page()
        {
            if( isset( $_SESSION['id'] ) && isset( $this->managers ) )
            {
                $userManager = $this->managers->getManagerOf('User') ;
                if( $this->appType == 'app' )
                    $userManager->updateLastAccess( $_SESSION['id'], $_SERVER['REQUEST_URI'], $_SERVER['REMOTE_ADDR'] ) ;
            }

            return $this->page;
        }
        
        public function setModule($module)
        {
            if (!is_string($module) || empty($module))
                throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
            
            $this->module = $module;
        }

        public function getModule()
        {
            return $this->module ;
        }

        public function setLanguages( $languages )
        {
            if ( empty( $languages ) )
                throw new \InvalidArgumentException('CONFIG: No languages specified');

            $this->languages = $languages ;
        }

        public function getLanguages()
        {
            return $this->languages ;
        }
        
        public function setAction($action)
        {
            if (!is_string($action) || empty($action))
                throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
            
            $this->action = $action;
        }
        
        public function setView($view)
        {
            if (!is_string($view) || empty($view))
                throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
            
            $this->view = $view ;
            $this->page->setContentFile(dirname(__FILE__).'/../../Views/'.$this->app->name().'/Modules/'.$this->module.'/'.$this->view.'.php');
        }

        public function getDataTablesRows( \Models\HTTPRequest $request, $object=null, $attributes=array(), $actionList=array( 'display','update','delete' ) )
        {
            if( $objectManager = $this->managers->getManagerOf( ucfirst( $object ) ) )
            {
                $params = array(    "object" => ucfirst( $object ),
                					"displayStart" => $request->postData('iDisplayStart'),
                                    "displayLength" => $request->postData('iDisplayLength'),
                                    "sortedColumns" => array(),
                                    "globalSearch" => array(),
                                    "columnSearch" => array()
                               );
                // SORTING
                for( $i=0; $i<=$request->postData('iSortingCols'); $i++ )
                {
                    if ( $request->postData( 'bSortable_'.$request->postData( 'iSortCol_'.$i ) ) == "true" )
                        $params['sortedColumns'][$request->postData( 'iSortCol_'.$i )] = $request->postData( 'sSortDir_'.$i ) ;
                }

                // GLOBAL FILTERING
                if( strlen( $request->postData('sSearch') ) > 0 )
                {
                    foreach( explode( '|', $request->postData('sSearch') ) as $search )
                        $params['globalSearch'][] = $search ;
                }

                // COLUMN FILTERING
                for ( $i=0 ; $i<count($attributes) ; $i++ )
                {
                    if ( $request->postExists( 'bSearchable_'.$i ) && $request->postData( 'bSearchable_'.$i ) == "true" && strlen( $request->postData( 'sSearch_'.$i ) ) > 0 )
                    {
                        foreach( explode( '|', $request->postData('sSearch_'.$i) ) as $search )
                            $params['columnSearch'][$i][] = $search ;
                    }
                }

                $output = $objectManager->getDataTables( $attributes, $params, $this->app->crypt(), $this->pageRestrictions, $this->globalRestrictions, $actionList ) ;

                if( $request->postExists('sEcho') )
                	$output['sEcho'] = intval( $request->postData('sEcho') ) ;
                else
                	$output['sEcho'] = 1 ;

                return json_encode( array_reverse( $output ) ) ;
            }
            else
                throw new \InvalidArgumentException('Unknown object');
        }

        public function getSelect2Rows( $search, $object, $searchFields=array(), $nameFields=array('name'), $where=null, $order="name ASC", $limit="0,256" )
        {
            if( !empty( $where ) )
                $where = "AND " . $where ;
            if( !empty( $order ) )
                $order = "ORDER BY " . $order ;
            if( !empty( $limit ) )
                $limit = "LIMIT " . $limit ;

            if( $objectManager = $this->managers->getManagerOf( ucfirst( $object ) ) )
                return json_encode( $objectManager->getSelect2( $search, $searchFields, $nameFields, $where, $order, $limit ) ) ;
            else
                throw new \InvalidArgumentException('Unknown object');
        }

        function displayGoogleAnalyticsScript()
        {
            $script = "<script type=\"text/javascript\">

                          var _gaq = _gaq || [];
                          _gaq.push(['_setAccount', '".$this->app->config()->get('googleAnalyticsPublicId')."']);
                          _gaq.push(['_trackPageview']);

                          (function() {
                            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                          })();

                    </script>" ;
            return $script ;
        }
    }
?>
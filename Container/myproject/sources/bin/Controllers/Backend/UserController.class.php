<?php
    namespace Controllers\Backend ;
    use \Models\Kernel\HTTPRequest ;

    class UserController extends \Models\Kernel\CoreController
    {
        public function executeIndex( HTTPRequest $request )
        {
            $this->page->addVar( 'title', 'Users' ) ;
            $this->page->addVar( 'users', \UserQuery::create()->find() ) ;
        }

        public function executeApi( HTTPRequest $request )
        {
            $values = json_decode( file_get_contents( "php://input" ), true ) ;
            if( !is_null( $values ) )
            {
                $user = new \User() ;
                $user->setFirstName( $values['firstName'] ) ;
                $user->setLastName( $values['lastName'] ) ;
                $user->setEmail( $values['email'] ) ;
                $user->save();
                echo $user->toJSON() ;
            }
            else
                echo json_encode( json_decode( \PeopleQuery::create()->select( array('firstName', 'lastName', 'email') )->find()->toJSON() ), JSON_PRETTY_PRINT ) ;
            exit;
        }
    }
?>
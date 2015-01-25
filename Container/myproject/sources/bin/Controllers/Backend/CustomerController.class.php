<?php
    namespace Controllers\Backend ;
    use \Models\Kernel\HTTPRequest ;

    class CustomerController extends \Models\Kernel\CoreController
    {
        public function executeIndex( HTTPRequest $request )
        {
            $this->page->addVar( 'title', 'Users' ) ;
            $this->page->addVar( 'customers', \CustomerQuery::create()->find() ) ;
        }

        public function executeApi( HTTPRequest $request )
        {
            $values = json_decode( file_get_contents( "php://input" ), true ) ;
            if( !is_null( $values ) )
            {
                $customer = new \Customer() ;
                $customer->setFirstname( $values['firstname'] ) ;
                $customer->setLastname( $values['lastname'] ) ;
                $customer->setEmail( $values['email'] ) ;
                $customer->setEmail2( $values['email2'] ) ;
                $customer->setStatus( 1 ) ;
                $customer->save();
                echo $customer->toJSON() ;
            }
            else
                echo json_encode( json_decode( \PeopleQuery::create()->select( array('firstname', 'lastname', 'email') )->find()->toJSON() ), JSON_PRETTY_PRINT ) ;
            exit;
        }
    }
?>
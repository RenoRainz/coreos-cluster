<?php
    namespace Models\Kernel ;
    
    class Page extends CoreApp
    {
        protected $contentFile ;
        protected $vars = array() ;
        
        public function addVar( $var, $value )
        {
            if ( !is_string($var) || is_numeric($var) || empty($var) )
            {
                throw new \InvalidArgumentException( 'Le nom de la variable doit &ecirc;tre une chaine de caract&egrave;re non nulle' ) ;
            }
            
            $this->vars[$var] = $value ;
        }
        
        public function getGeneratedPage()
        {
            if ( !file_exists( $this->contentFile ) )
            {
                throw new \RuntimeException('La vue sp&eacute;cifi&eacute;e n\'existe pas') ;
            }

            $auth = new Auth ;
            $lang = new Lang( $this->app->name(), $this->app->auth()->lang() ) ;

            
            extract( $this->vars ) ;
            
            ob_start() ;
                require $this->contentFile ;
            $content = ob_get_clean() ;
            
            ob_start() ;
                require dirname(__FILE__).'/../../Views/'.$this->app->name().'/Outputs/Http/layout.php' ;
            return ob_get_clean() ;
        }

        public function getGeneratedAjax()
        {
            if ( !file_exists( $this->contentFile ) )
            {
                throw new \RuntimeException('La vue sp&eacute;cifi&eacute;e n\'existe pas') ;
            }

            $auth = new Auth ;
            $lang = new Lang( $this->app->name(), $this->app->auth()->lang() ) ;

            extract( $this->vars ) ;
            
            ob_start() ;
                require $this->contentFile ;
            return ob_get_clean() ;
        }
        
        public function setContentFile( $contentFile )
        {
            if ( !is_string( $contentFile ) || empty( $contentFile ) )
            {
                throw new \InvalidArgumentException( 'La vue sp&eacute;cifi&eacute;e est invalide' ) ;
            }

            $this->contentFile = $contentFile ;
        }

        // HTML Functions

        function createRadio( $fields, $name, $default, $object )
        {
            $output = "<div class='btn-group' data-toggle='buttons' id='$name'>" ;
            $checked = null ;
            foreach( $fields as $key => $value )
            {
                if ( ( isset( $object[$name] ) && $object[$name]==$key ) || !isset( $object[$name] ) && $key==$default )
                    $output .= "<label class='btn btn-default active'><input type='radio' class='toggle' name='$name' value='$key' checked='checked'>$value</label>";
                else
                    $output .= "<label class='btn btn-default'><input type='radio' class='toggle' name='$name' value='$key'>$value</label>";

                if( !is_null( $checked ) )
                    $checked = null ;
            }
            return $output . "</div>" ;
        }

        function createSelect( $fields, $name, $default, $object )
        {
            $output = "<select class='form-control' name='$name' id='$name'>" ;
            $selected = null ;
            foreach( $fields as $key => $value )
            {
                if ( ( isset( $object[$name] ) && $object[$name]==$key ) || !isset( $object[$name] ) && $key==$default )
                    $selected = "selected='selected'" ;
                
                $output .= "<option value='$key' $selected />$value</option>" ;

                if( !is_null( $selected ) )
                    $selected = null ;
            }
            return $output . "</select>" ;
        }

        function createSelect2( $remoteObjectName, $name, $object, $type, $lang, $nameFields=array('name') )
        {
            $sortableJS = null ;
            $fieldType = "text" ;
            if( $type == "sortable" )
            {
                $sortableJS =   "$('#".$remoteObjectName."_select2').select2('container').find('ul.select2-choices').sortable({
                                    containment: 'parent',
                                    start: function() { $('#".$remoteObjectName."_select2').select2('onSortStart'); },
                                    update: function() { $('#".$remoteObjectName."_select2').select2('onSortEnd'); }
                                });" ;
                $fieldType = "hidden" ;
            }
                

            $output = " <script type='text/javascript'>
                            $(document).ready( function() {
                                $('#".$remoteObjectName."_select2').select2({
                                    placeholder: '". $lang->txt('search') ."',
                                    multiple: true,
                                    minimumInputLength: 0,
                                    maximumSelectionSize: 0,
                                    separator: '|',
                                    ajax: {
                                        url: '/console/ajax/".$remoteObjectName."/select2',
                                        dataType: 'json',
                                        quietMillis: 100,
                                        data: function (term, page) { // page is the one-based page number tracked by Select2
                                            return {
                                                search: term,
                                            };
                                        },
                                        results: function (data, page) {
                                            //var more = (page * 10) < data.total; // whether or not there are more results available
                                            // notice we return the value of more so Select2 knows if more results can be loaded
                                            return {results: data.datas};
                                        }
                                    },
                                    formatResult: function (item) { return item.name; },
                                    formatSelection: function (item) { return item.name; },
                                    escapeMarkup: function (m) { return m; }
                                });" ;

            if( isset( $object ) && count( $object[$name] ) > 0 )
            {
                $initValues = null ;
                foreach( $object[$name] as $value )
                {
                    $initValues .= "{id: '".$value['id']."', name: '" ;
                    foreach( $nameFields as $nameField )
                        $initValues .= $value[$nameField] . " " ;
                    $initValues = substr( $initValues, 0, -1 ) . "'}," ;
                }
                $output .= "$('#".$remoteObjectName."_select2').select2( 'data', [".substr( $initValues, 0, -1 )."] ) ;" ;
            }

            $output .= $sortableJS ;

            $output .=          "
                            });
                        </script>
                        <input class='form-control' type='".$fieldType."' id='".$remoteObjectName."_select2' name='".$name."' value='' />" ;
            return $output ;
        }

        public function displayByteFormat( $size )
        {
          # size smaller then 1kb
          if ($size < 1024) return $size . ' B';
          # size smaller then 1mb
          if ($size < 1048576) return sprintf("%4.2f KB", $size/1024);
          # size smaller then 1gb
          if ($size < 1073741824) return sprintf("%4.2f MB", $size/1048576);
          # size smaller then 1tb
          if ($size < 1099511627776) return sprintf("%4.2f GB", $size/1073741824);
          # size larger then 1tb
          else return sprintf("%4.2f TB", $size/1073741824);
        }
    }
?>
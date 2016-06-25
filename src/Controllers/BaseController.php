<?php
namespace Himl\Controllers;;

class BaseController
{
    function loadView ($strViewPath, $arrayOfData = array())
    {
        extract($arrayOfData);
        // Require the file
        ob_start();
        require($strViewPath);

        // Return the string
        $strView = ob_get_contents();
        ob_end_clean();
        return $strView;
    }
}
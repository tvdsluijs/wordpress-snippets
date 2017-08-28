<?php
/**
 * Bootstrap accordion forms
 *
 * Small script to show multiple Contact 7 Forms in a Bootstrap accordion
 * how to use : [showAccordionForms titles="Formulier 1, Formulier 2" forms="4, 1706"]
 * 
 * @project    snippets
 * @author     Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright  2017 Theo van der Sluijs
 * @license    All rights reserved
 * @file       boostrap-accordion-forms.php
 * @date       17/08/2017
 * @time       09:23
 */
 
function setAccordionForms($arr) {
        extract( shortcode_atts( array(
        'titles' => 'Title',
        'forms' => '1'
    ), $arr));
  
  $titles = explode(",", $titles);
  $forms = explode(",", $forms);  
  
    $string = "";
    $string .= "<div class='panel-group' id='accordion'>";
    foreach($titles as $key => $title){
        $string .= "<div class='panel panel-default'>";
        $string .= "<div class='panel-heading'>";
        $string .= "<h4 class='panel-title'>";
        $string .= "<a data-toggle='collapse' data-parent='#accordion' href='#collapse{$key}'>";
        $string .= "{$title}</a>";
        $string .= "</h4>";
        $string .= "</div>";
        $string .= "<div id='collapse{$key}' class='panel-collapse collapse in'>";
        
	  	$formID = $forms[$key];
	  
        $form = do_shortcode( "[contact-form-7 id='{$formID}' title='{$title}']");
        
        $string .= "<div class='panel-body'>{$form}</div>";
        $string .= "</div>";
        $string .= "</div>";
    }
$string .= "</div>";

echo $string;
    
}

add_shortcode('showAccordionForms', 'setAccordionForms');
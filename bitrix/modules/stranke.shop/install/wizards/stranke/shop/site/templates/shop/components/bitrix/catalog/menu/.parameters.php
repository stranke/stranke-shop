<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(

  "SEF_MODE" => Array(
    "element" => array(
      "NAME" => 'element',
      "DEFAULT" => "#ELEMENT_CODE#/",
      "VARIABLES" => array(),
    ),

    "element_description" => array(
      "NAME" => 'element_description',
      "DEFAULT" => "#ELEMENT_CODE#/description/",
      "VARIABLES" => array(),
    ),

    "element_photo" => array(
      "NAME" => 'element_photo',
      "DEFAULT" => "#ELEMENT_CODE#/photo/",
      "VARIABLES" => array(),
    ),

    "element_properties" => array(
      "NAME" => 'element_properties',
      "DEFAULT" => "#ELEMENT_CODE#/properties/",
      "VARIABLES" => array(),
    ),

    "element_reviews" => array(
      "NAME" => 'element_reviews',
      "DEFAULT" => "#ELEMENT_CODE#/reviews/",
      "VARIABLES" => array(),
    ),

    "element_related-products" => array(
      "NAME" => 'element_related-products',
      "DEFAULT" => "#ELEMENT_CODE#/related-products/",
      "VARIABLES" => array(),
    ),

    "compare" => array(
      "NAME" => 'compare',
      "DEFAULT" => "compare.php?action=#ACTION_CODE#",
      "VARIABLES" => array(),
    ),

    "smart_filter" => array(
      "NAME" => 'smart_filter',
      "DEFAULT" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
      "VARIABLES" => array(),
    ),

    "sections" => array(
      "NAME" => 'sections',
      "DEFAULT" => "",
      "VARIABLES" => array(),
    ),

    "section" => array(
      "NAME" => 'section',
      "DEFAULT" => "#SECTION_CODE_PATH#/",
      "VARIABLES" => array(),
    ),
  ),
);
?>
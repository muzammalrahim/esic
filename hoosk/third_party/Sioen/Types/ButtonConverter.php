<?php


class ButtonConverter extends BaseConverter implements ConverterInterface
{
    public function toJson(\DOMElement $node)
    {
        $html = $node->ownerDocument->saveXML($node);
        return array(
            'type' => 'button',
            'data' => array(
                'size' => array(),
                'alignment' => array(),
                'style' => $node->getAttribute('class'),
                'width' => array(),
                'url' => $node->getAttribute('href'),
                'html' => $this->htmlToMarkdown($html)
            )
        );
    }               
    public function toHtml(array $data)
    {
	    //echo "<pre>";
        //print_r($data);
       // //die();
      //  return '<a href="' . $data['url'] . '" class="' . $data['style'] . ' ' . $data['size'] . '">' . $data['html'] . '</a>' . "\n";
      $block = "";
      if($data['width'] == 'btn-block'){
        $block ="btn-block";
      }
      $alignment = $data['alignment'];
      $html =   '<div class="st-button-container" style="text-align: '.$alignment.'" >';
      $html .= '<a href="' . $data['url'] . '" class="btn ' . $data['style'] . ' ' . $data['size'] . $block .'">';
      $html .=  $data['html'] . '</a></div>' . "\n";
      return $html;
    }
}

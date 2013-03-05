<?php
class RLinkPager extends CLinkPager
{
  const CSS_SELECTED_PAGE = 'pselected';
  
  public function init()
  {
    if (!isset($this->htmlOptions['id']))
    $this->htmlOptions['id'] = $this->getId();
    $this->htmlOptions['class'] = 'pages';
  }
  
  protected function createPageButtons()
  {
    if (($pageCount = $this->getPageCount()) <= 1)
    return array();
    
    list($beginPage, $endPage) = $this->getPageRange();
    $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
    $buttons = array();
    // prev page
    if (($page = $currentPage - 1) < 0)
    $page = 0;
    $buttons[] = '<a href="' . $this->createPageUrl($page) . '" class="prev"></a>';
    
    // internal pages
    for ($i = $beginPage; $i <= $endPage; ++$i)
    $buttons[] = $this->createPageButton($i + 1, $i, $this->internalPageCssClass, false, $i == $currentPage);
    
    // next page
    if (($page = $currentPage + 1) >= $pageCount - 1)
    $page = $pageCount - 1;
    $buttons[] = '<a href="' . $this->createPageUrl($page) . '" class="next"></a>';
    return $buttons;
  }
  
  public function run()
  {
    $buttons = $this->createPageButtons();
    if (empty($buttons))
    return;
    $this->registerClientScript();
    echo CHtml::tag('div', $this->htmlOptions, implode('', $buttons));
    
  }
  
  protected function createPageButton($label, $page, $class, $hidden, $selected)
  {
    $txt = CHtml::link($label, $this->createPageUrl($page));
    if ($hidden) $txt = '';
  elseif ($selected) $txt = '<span>' . ($page + 1) . '</span>';
    
    return $txt;
  }
  
}

?>

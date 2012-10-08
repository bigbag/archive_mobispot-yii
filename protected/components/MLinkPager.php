<?php
class MLinkPager extends CLinkPager
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
        if ($currentPage > 0) {
            $buttons[] = '<span class="prev"><a href="' . $this->createPageUrl($page) . '" >&larr;&nbsp;' . Yii::t('general', 'Назад') . '</a></span>';
        }

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1)
            $page = $pageCount - 1;
        if ($currentPage < $pageCount - 1) {
            $buttons[] = '<span class="next"><a href="' . $this->createPageUrl($page) . '" >' . Yii::t('general', 'Показать ещё') . '&nbsp;&rarr;</a></span>';
        }

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

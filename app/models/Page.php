<?php

namespace app\models;

use RedBeanPHP\R;

class Page extends AppModel
{
    public function get_page($slug,$lang) : array
    {
        return R::getRow("SELECT page.*,pd.* FROM page JOIN page_description pd on page.id = pd.page_id WHERE page.slug=? AND pd.language_id=?", [$slug,$lang['id']]);

    }
}
<?php

class Home extends Controllers{
    public function __construct()
    {
        parent::__construct();
    }

    //Vista principal Home.php
    public function home()
    {
        $data['page_id'] = 1;
        $data['page_tag'] = "Home";
        $data['page_title'] = "Pagina principal";
        $data['page_name'] = "home";
        $data['page_content'] = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quam quibusdam officia explicabo sint? Deleniti illo amet eos necessitatibus repellat ipsum ipsa porro expedita. Velit voluptatem quisquam nobis blanditiis illum tempora";
        $this->views->getView($this, "home", $data);
    }
}
?>
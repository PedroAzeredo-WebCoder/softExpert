<?php

/**
 * @package template
 * @subpackage class_base
 * @author pedro-azeredo <pedro.azeredo93@gmail.com>
 */

class Template
{

    private $getCss;
    private $getJs;
    private $breadcrumb;
    private $setTittle;
    private $content;
    private $template;

    public function __construct($tittle = NULL)
    {
        $this->setTemplate();
        $this->setTittle = $tittle;
    }

    /**
     * setTemplate
     * Setar template default a ser utilizado na execução da classe
     *
     * @param string $template
     */
    public function setTemplate(string $template = "index")
    {

        if (file_exists(__DIR__ . '/templates/template.' . $template . '.php')) {
            $this->template = __DIR__ . '/templates/template.' . $template . '.php';
            return;
        }
        $this->template = __DIR__ . '/templates/template.index.php';
    }

    private function getTemplate()
    {
        if (file_exists($this->template)) {
            $outString = implode("", file($this->template));
            return $outString;
        }
        $outString = implode("", file($this->template));
        return $outString;
    }

    /**
     * addCss
     * Responsável por registrar CSSs no template
     *
     * @param mixed $cssString
     */
    public function addCss(string $cssString)
    {
        if (file_exists($cssString)) {
            $this->getCss .= "<link href='" . $cssString . "' rel='stylesheet' type='text/css'>";
        } else {
            $this->getCss .= "<s>" . $cssString . "</style>";
        }
    }

    /**
     * addJs
     * Responsável por registrar JSs no template
     *
     * @param mixed $cssString
     */
    public function addJs(string $jsString)
    {
        if (file_exists($jsString)) {
            $this->getJs .= "<link href='" . $jsString . "' rel='stylesheet' type='text/css'>";
        } else {
            $this->getJs .= "<script>" . $jsString . "</script>";
        }
    }

    /**
     * addBreadcrumb
     * Cria código para definir breadcrump (caminho) da tela
     *
     * @param string $local
     * @param string $active
     * @param string $url
     */
    public function addBreadcrumb(string $local, string $url = NULL)
    {
        if ($url != NULL) {
            $content = "<li class='breadcrumb-item'><a href='./" . $url . "'>" . $local . "</a></li>";
        } else {
            $content = "<li class='breadcrumb-item active'>" . $local . "</li>";
        }

        $this->breadcrumb .= $content;
    }

    /**
     * getBreadcrumb
     * Responsável por criar o HTML de breadcrumpb (caminho)
     *
     * @return string
     */
    private function getBreadcrumb(): string
    {

        // incluindo no breadcrumpb automaticamente a página atual
        // $this->addBreadcrumb($this->setTittle);

        $outHtml  = "<ol class='breadcrumb'>";
        $outHtml .= $this->breadcrumb;
        $outHtml .= "</ol>";
        return $outHtml;
    }

    /**
     * addContent
     * Inclusão de conteúdo no template utilizado
     *
     * @param string $content
     * @param string $card
     */
    public function addContent(string $content, string $card = NULL)
    {
        if ($card == true) {
            $this->content .= "
                <div class='card'>
                    <div class='card-body'>
                        <div class='card-text'>
                            " . $content . "
                        </div>
                    </div>
                </div>
                ";
        } else {
            $this->content .= $content;
        }
    }

    /**
     * writeHtml
     * Imprimir HTML montado após conclusão das definições do template
     *
     * @return void
     */
    public function writeHtml()
    {
        $outHtml = $this->__replace($this->getTemplate(),   "[%description%]",       META["description"]);
        $outHtml = $this->__replace($outHtml,               "[%author%]",            META["author"]);
        $outHtml = $this->__replace($outHtml,               "[%icon%]",              META["icon"]);
        $outHtml = $this->__replace($outHtml,               "[%title%]",             TITTLE);
        $outHtml = $this->__replace($outHtml,               "[%title_page%]",        $this->setTittle);
        $outHtml = $this->__replace($outHtml,               "[%css%]",               $this->getCss);
        $outHtml = $this->__replace($outHtml,               "[%breadcrumb%]",        $this->getBreadcrumb());
        $outHtml = $this->__replace($outHtml,               "[%include_sidebar%]",   $this->getSidebar());
        $outHtml = $this->__replace($outHtml,               "[%include_topbar%]",    $this->getTopbar());
        $outHtml = $this->__replace($outHtml,               "[%include_content%]",   $this->content);
        $outHtml = $this->__replace($outHtml,               "[%js%]",                $this->getJs);
        $outHtml = $this->__replace($outHtml,               "[%sweetalert%]",        getAlert());
        echo $outHtml;
    }

    /**
     * getSidebar
     * Responsável pela montagem do sideBar (menu)
     *
     * @return string
     */
    private function getSidebar(): string
    {

        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD) or print($conn->errorInfo());

        $sql = "
            SELECT
                id,
                adm_menu_id,
                icone,
                nome,
                link,
                status,
                (
                SELECT
                    COUNT(*)
                FROM
                    adm_menu as aa
                WHERE
                    aa.status = 1
                    AND aa.adm_menu_id = adm_menu.id
                    AND aa.tipo = '" . getUserInfo('tipo') . "'
                ) as subItens
            FROM
                adm_menu 
            WHERE
                status = 1
                AND adm_menu_id IS NULL
                AND tipo = '" . getUserInfo('tipo') . "'
            ORDER BY
                nome ASC
        ";

        $menu = array();
        if ($conn->query($sql)) {
            foreach ($conn->query($sql) as $row) {
                if ($row["subItens"] == 0) {
                    $menu[] = "
                            <li class='nav-item'>
                                <a class='d-flex align-items-center' href='" . $row["link"] . "'>
                                    <i data-feather='" . $row["icone"] . "'></i>
                                    <span class='menu-item text-truncate' data-i18n='" . $row["nome"] . "'>" . $row["nome"] . "</span>
                                </a>
                            </li>
                        ";
                } else {

                    $sqlSubItens = "
                        SELECT
                            id,
                            nome,
                            link
                        FROM
                            adm_menu
                        WHERE
                            status = 1
                            AND adm_menu_id = {$row['id']}
                            AND tipo = '" . getUserInfo('tipo') . "'
                        ORDER BY 
                            nome ASC
                    ";

                    $menuSubItens = array();
                    if ($conn->query($sqlSubItens)) {
                        foreach ($conn->query($sqlSubItens) as $rowSubItens) {
                            $menuSubItens[] = "
                                <li>
                                    <a class='d-flex align-items-center' href='" . $rowSubItens["link"] . "'>
                                        <i data-feather='disc'></i>
                                        <span class='menu-item text-truncate' data-i18n='" . $rowSubItens["nome"] . "'>" . $rowSubItens["nome"] . "</span>
                                    </a>
                                </li>";
                        }
                    }

                    $menu[] = "
                            <li class='nav-item'>
                                <a class='d-flex align-items-center' href='#'>
                                    <i data-feather='" . $row["icone"] . "'></i>
                                    <span class='menu-title text-truncate' data-i18n='" . $row["nome"] . "'>" . $row["nome"] . "</span>
                                </a>
                                    
                                <ul class='menu-content'>
                                    " . implode('', $menuSubItens) . "
                                </ul>
                            </li>
                        ";
                }
            }
        }

        $outHtml = "
                <div class='main-menu-content'>
                    <ul class='navigation navigation-main' id='main-menu-navigation' data-menu='menu-navigation'>
                        <li class='nav-item'>
                            <a class='d-flex align-items-center' href='index.php'>
                                <i data-feather='home'></i>
                                <span class='menu-item text-truncate' data-i18n='Dashboard'>Dashboard</span>
                            </a>
                        </li>
                        " . implode("", $menu) . "
                        <li class='nav-item'>
                            <a class='d-flex align-items-center' href='loginSair.php'>
                                <i data-feather='log-out'></i>
                                <span class='menu-item text-truncate' data-i18n='Sair'>Sair</span>
                            </a>
                        </li>
                    </ul>
                </div>
            ";
        return $outHtml;
    }

    /**
     * gettopbar
     * Responsável por criar o topbar
     *
     * @return void
     */
    private function getTopbar()
    {
        $outHtml = "
            <nav class='header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow' data-aos='fade-down' data-aos-anchor-placement='top-bottom' data-aos-duration='800'>
                <div class='navbar-container d-flex content'>
                    <div class='bookmark-wrapper d-flex align-items-center'>
                        <ul class='nav navbar-nav d-xl-none'>
                            <li class='nav-item'><a class='nav-link menu-toggle' href='#'><i class='ficon' data-feather='menu'></i></a></li>
                        </ul>
                        <ul class='nav navbar-nav'>
                        <!--<li class='nav-item d-none d-lg-block'><a class='nav-link nav-link-style'><i class='ficon' data-feather='moon'></i></a></li>-->
                        </ul>
                    </div>
                    <ul class='nav navbar-nav align-items-center ms-auto'>
                        <li class='nav-item dropdown dropdown-user'>
                            <a class='nav-link dropdown-toggle dropdown-user-link' id='dropdown-user' href='#' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                <div class='user-nav'>
                                    <span class='user-name fw-bolder'>" . getDbValue("SELECT nome FROM cad_usuarios WHERE uniqid = '" . getSession("SYSGER") . "'") . "</span>
                                    
                                </div>
                            </a>
                            <div class='dropdown-menu dropdown-menu-end' aria-labelledby='dropdown-user'>
                                <!-- <a class='dropdown-item' href='#'><i class='me-50' data-feather='user'></i> Perfil</a> -->
                                <!-- <div class='dropdown-divider'></div> -->
                                <a class='dropdown-item' href='loginSair.php'><i class='me-50' data-feather='log-out'></i> Sair</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            ";

        return $outHtml;
    }

    /**
     * __replace
     * Responsável por fazer o str_replace no arquivo template
     *
     * @param [type] $string
     * @param [type] $search
     * @param [type] $replace
     * @return string
     */
    private function __replace($string, $search, $replace): string
    {
        $replaced = "";
        if (!is_array($replace)) {
            $replace = array($replace);
        }
        $replaced = str_replace($search, implode("\r\n", $replace), $string);
        return $replaced;
    }
}

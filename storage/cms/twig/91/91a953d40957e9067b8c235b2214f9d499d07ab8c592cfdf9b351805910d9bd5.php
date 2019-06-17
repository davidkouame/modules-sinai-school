<?php

/* /Applications/MAMP/htdocs/Sinai-school/themes/default/layouts/home.htm */
class __TwigTemplate_50354fc95d26a623851b619fc7a1992e00a2ff0b55ff6df9d21259cdcecdd369 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <!--<title>October CMS - ";
        // line 5
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["this"] ?? null), "page", []), "title", []), "html", null, true);
        echo "</title>
        <meta name=\"description\" content=\"";
        // line 6
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["this"] ?? null), "page", []), "meta_description", []), "html", null, true);
        echo "\">
        <meta name=\"title\" content=\"Sinai-School}\">
        <meta name=\"author\" content=\"OctoberCMS\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"generator\" content=\"OctoberCMS\">-->
        <!--<link rel=\"icon\" type=\"image/png\" href=\"";
        // line 11
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/images/october.png");
        echo "\">
        <link href=\"";
        // line 12
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/css/vendor.css");
        echo "\" rel=\"stylesheet\">
        <link href=\"";
        // line 13
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/css/theme.css");
        echo "\" rel=\"stylesheet\">-->


        <!-- <title>";
        // line 16
        $this->displayBlock('title', $context, $blocks);
        echo "</title> -->
        <title>Sinai-School</title>
        <!-- Meta -->
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"description\" content=\"\">
        <meta name=\"author\" content=\"\">    
        <link rel=\"shortcut icon\" href=\"favicon.ico\">  
        <!--x<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>-->
        <!-- FontAwesome JS-->
        <script defer src=\"";
        // line 27
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/js/all.js");
        echo "\" integrity=\"sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9\" crossorigin=\"anonymous\"></script>

        <!-- Global CSS -->
        <link href=\"";
        // line 30
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/plugins/bootstrap/css/bootstrap.css");
        echo "\" rel=\"stylesheet\">
        <!-- Plugins CSS -->
        <link href=\"";
        // line 32
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/plugins/flexslider/css/flexslider.css");
        echo "\" rel=\"stylesheet\">
        <!-- Theme CSS -->  
        <link id=\"theme-style\" rel=\"stylesheet\" href=\"./static/assets/css/theme-1.css\">
        <link href=\"";
        // line 35
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/css/theme-1.css");
        echo "\" rel=\"stylesheet\">

        <!-- APP css-->
        <link rel=\"stylesheet\" href=\"";
        // line 38
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/css/app.css");
        echo "\">


        <!-- Facebook Pixel Code -->
        <!--<script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '1506230579705064');
          fbq('track', 'PageView');
        </script>-->
    <noscript><img height=\"1\" width=\"1\" style=\"display:none\"
                   src=\"https://www.facebook.com/tr?id=1506230579705064&ev=PageView&noscript=1\"
                   /></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- css add -->
    <style type=\"text/css\">
        .home-page section.news {
            background: #fff;
        }

        .home-page .news .news-item {
            margin-bottom: 36px;
        }

        .jss374 {
            width: 100%;
            height: auto;
            margin: 0;
            display: block;
            padding: 0;
            padding-bottom: 56.25%;
            background-size: cover;
            background-color: #d2d2d2;
            background-position: center;
        }

        .item.carousel-item.active{
            margin-bottom: 2%;
        }


        /*img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 150px;
        }

        img:hover {
        box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }*/

        .profile:hover{
            box-shadow: initial;
        }

        .item.carousel-item{
            cursor: pointer
        }

        .no-padding-left-and-right{
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

    </style>
    ";
        // line 111
        echo $this->env->getExtension('Cms\Twig\Extension')->assetsFunction('css');
        echo $this->env->getExtension('Cms\Twig\Extension')->displayBlock('styles');
        // line 112
        echo "    <script src=\"";
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/plugins/popover/popper.min.js");
        echo "\"></script>

    <!-- Scripts -->
    <script src=\"";
        // line 115
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/vendor/jquery.js");
        echo "\"></script>
    <script src=\"";
        // line 116
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/vendor/bootstrap.js");
        echo "\"></script>
    <script src=\"";
        // line 117
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/javascript/app.js");
        echo "\"></script>

    <!-- JS --> 
    <!--    <script src=\"";
        // line 120
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/plugins/jquery/jquery-3.3.1.min.js");
        echo "\"></script>-->
    <script src=\"";
        // line 121
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/plugins/bootstrap/js/bootstrap.min.js");
        echo "\"></script>
    <script src=\"";
        // line 122
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/js/back-to-top.js");
        echo "\"></script>
    <script src=\"";
        // line 123
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/plugins/jquery-placeholder/jquery.placeholder.js");
        echo "\"></script>
    <script src=\"";
        // line 124
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/plugins/pretty-photo/js/jquery.prettyPhoto.js");
        echo "\"></script>
    <script src=\"";
        // line 125
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/plugins/flexslider/js/jquery.flexslider-min.js");
        echo "\"></script>
    <script src=\"";
        // line 126
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/js/jflickrfeed.min.js");
        echo "\"></script>
    <script src=\"";
        // line 127
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/js/main.js");
        echo "\"></script>

</head>
<body class=\"home-page\">

    <!-- Content -->
    <section id=\"layout-content\">
        <div class=\"wrapper\">
            ";
        // line 135
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->partialFunction("site/header1"        , $context['__cms_partial_params']        , true        );
        unset($context['__cms_partial_params']);
        // line 136
        echo "            <div class=\"content container\">
                ";
        // line 137
        $context['__cms_component_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->componentFunction("SlideShow"        , $context['__cms_component_params']        );
        unset($context['__cms_component_params']);
        // line 138
        echo "                <div class=\"row cols-wrapper\">
                    <div class=\"col-lg-9 col-12\">";
        // line 139
        echo $this->env->getExtension('Cms\Twig\Extension')->pageFunction();
        echo "</div>
                    <div class=\"col-lg-3 col-12\">";
        // line 140
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->partialFunction("site/navabar-right"        , $context['__cms_partial_params']        , true        );
        unset($context['__cms_partial_params']);
        echo "</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class=\"footer\">
        ";
        // line 148
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->partialFunction("site/footer"        , $context['__cms_partial_params']        , true        );
        unset($context['__cms_partial_params']);
        // line 149
        echo "    </footer>

    <!-- Theme Switcher (REMOVE ON YOUR PRODUCTION SITE) -->
    <script src=\"";
        // line 152
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/js/theme-switcher.js");
        echo "\"></script>
    ";
        // line 153
        $_minify = System\Classes\CombineAssets::instance()->useMinify;
        if ($_minify) {
            echo '<script src="'. Request::getBasePath()
                    .'/modules/system/assets/js/framework.combined-min.js"></script>'.PHP_EOL;
        }
        else {
            echo '<script src="'. Request::getBasePath()
                    .'/modules/system/assets/js/framework.js"></script>'.PHP_EOL;
            echo '<script src="'. Request::getBasePath()
                    .'/modules/system/assets/js/framework.extras.js"></script>'.PHP_EOL;
        }
        echo '<link rel="stylesheet" property="stylesheet" href="'. Request::getBasePath()
                    .'/modules/system/assets/css/framework.extras'.($_minify ? '-min' : '').'.css">'.PHP_EOL;
        unset($_minify);
        // line 154
        echo "    ";
        echo $this->env->getExtension('Cms\Twig\Extension')->assetsFunction('js');
        echo $this->env->getExtension('Cms\Twig\Extension')->displayBlock('scripts');
        // line 155
        echo "
    <script type=\"text/javascript\">
\$(document).ready(function () {
    \$(\".carousel-item div.row\").click(function (e) {
        window.location.href = \"";
        // line 159
        echo url("actualites");
        echo "/\" + \$(this).data('id');
    });
    
    \$(\".";
        // line 162
        echo twig_escape_filter($this->env, ($context["active"] ?? null), "html", null, true);
        echo "\").addClass(\"active\");

    \$(\".carousel-item div.row\").click(function (e) {
        window.location.href = \"";
        // line 165
        echo url("clubs-activites");
        echo "/\" + \$(this).data('idclub');
    });

    /*('.link-mot-directeur').click(function(){
     console.log(\$(this).data('click'))
     
     });*/

    // alert(\"dsds\");

    /* ======= Flexslider ======= */
    \$('.flexslider').flexslider({
        animation: \"fade\"
    });

    /* ======= jQuery Placeholder ======= */
    \$('input, textarea').placeholder();


    /* ======= Carousels ======= */
    \$('#news-carousel').carousel({interval: false});
    \$('#videos-carousel').carousel({interval: false});
    \$('#testimonials-carousel').carousel({interval: 6000, pause: \"hover\"});
    \$('#awards-carousel').carousel({interval: false});


    /* ======= Flickr PhotoStream ======= */
    \$('#flickr-photos').jflickrfeed({
        limit: 12,
        qstrings: {
            id: '32104790@N02' /* Use idGettr.com to find the flickr user id */
        },
        itemTemplate:
                '<li>' +
                '<a rel=\"prettyPhoto[flickr]\" href=\"";
        // line 199
        echo twig_escape_filter($this->env, ($context["image"] ?? null), "html", null, true);
        echo "\" title=\"";
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "\">' +
                '<img src=\"";
        // line 200
        echo twig_escape_filter($this->env, ($context["image_s"] ?? null), "html", null, true);
        echo "\" alt=\"";
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "\" />' +
                '</a>' +
                '</li>'

    }, function (data) {
        \$('#flickr-photos a').prettyPhoto();
    });

    /* ======= Pretty Photo ======= */
    \$('a.prettyphoto').prettyPhoto();
});
    </script>
</body>
</html>";
    }

    // line 16
    public function block_title($context, array $blocks = [])
    {
        echo "This is my new project home page";
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/Sinai-school/themes/default/layouts/home.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  376 => 16,  356 => 200,  350 => 199,  313 => 165,  307 => 162,  301 => 159,  295 => 155,  291 => 154,  276 => 153,  272 => 152,  267 => 149,  263 => 148,  250 => 140,  246 => 139,  243 => 138,  239 => 137,  236 => 136,  232 => 135,  221 => 127,  217 => 126,  213 => 125,  209 => 124,  205 => 123,  201 => 122,  197 => 121,  193 => 120,  187 => 117,  183 => 116,  179 => 115,  172 => 112,  169 => 111,  93 => 38,  87 => 35,  81 => 32,  76 => 30,  70 => 27,  56 => 16,  50 => 13,  46 => 12,  42 => 11,  34 => 6,  30 => 5,  24 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <!--<title>October CMS - {{ this.page.title }}</title>
        <meta name=\"description\" content=\"{{ this.page.meta_description }}\">
        <meta name=\"title\" content=\"Sinai-School}\">
        <meta name=\"author\" content=\"OctoberCMS\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"generator\" content=\"OctoberCMS\">-->
        <!--<link rel=\"icon\" type=\"image/png\" href=\"{{ 'assets/images/october.png'|theme }}\">
        <link href=\"{{ 'assets/css/vendor.css'|theme }}\" rel=\"stylesheet\">
        <link href=\"{{ 'assets/css/theme.css'|theme }}\" rel=\"stylesheet\">-->


        <!-- <title>{% block title %}This is my new project home page{% endblock title %}</title> -->
        <title>Sinai-School</title>
        <!-- Meta -->
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"description\" content=\"\">
        <meta name=\"author\" content=\"\">    
        <link rel=\"shortcut icon\" href=\"favicon.ico\">  
        <!--x<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>-->
        <!-- FontAwesome JS-->
        <script defer src=\"{{ 'assets/js/all.js'|theme }}\" integrity=\"sha384-3LK/3kTpDE/Pkp8gTNp2gR/2gOiwQ6QaO7Td0zV76UFJVhqLl4Vl3KL1We6q6wR9\" crossorigin=\"anonymous\"></script>

        <!-- Global CSS -->
        <link href=\"{{ 'assets/plugins/bootstrap/css/bootstrap.css'|theme }}\" rel=\"stylesheet\">
        <!-- Plugins CSS -->
        <link href=\"{{ 'assets/plugins/flexslider/css/flexslider.css'|theme }}\" rel=\"stylesheet\">
        <!-- Theme CSS -->  
        <link id=\"theme-style\" rel=\"stylesheet\" href=\"./static/assets/css/theme-1.css\">
        <link href=\"{{ 'assets/css/theme-1.css'|theme }}\" rel=\"stylesheet\">

        <!-- APP css-->
        <link rel=\"stylesheet\" href=\"{{ 'assets/css/app.css'|theme }}\">


        <!-- Facebook Pixel Code -->
        <!--<script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '1506230579705064');
          fbq('track', 'PageView');
        </script>-->
    <noscript><img height=\"1\" width=\"1\" style=\"display:none\"
                   src=\"https://www.facebook.com/tr?id=1506230579705064&ev=PageView&noscript=1\"
                   /></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- css add -->
    <style type=\"text/css\">
        .home-page section.news {
            background: #fff;
        }

        .home-page .news .news-item {
            margin-bottom: 36px;
        }

        .jss374 {
            width: 100%;
            height: auto;
            margin: 0;
            display: block;
            padding: 0;
            padding-bottom: 56.25%;
            background-size: cover;
            background-color: #d2d2d2;
            background-position: center;
        }

        .item.carousel-item.active{
            margin-bottom: 2%;
        }


        /*img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 150px;
        }

        img:hover {
        box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }*/

        .profile:hover{
            box-shadow: initial;
        }

        .item.carousel-item{
            cursor: pointer
        }

        .no-padding-left-and-right{
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

    </style>
    {% styles %}
    <script src=\"{{ 'assets/plugins/popover/popper.min.js'|theme }}\"></script>

    <!-- Scripts -->
    <script src=\"{{ 'assets/vendor/jquery.js'|theme }}\"></script>
    <script src=\"{{ 'assets/vendor/bootstrap.js'|theme }}\"></script>
    <script src=\"{{ 'assets/javascript/app.js'|theme }}\"></script>

    <!-- JS --> 
    <!--    <script src=\"{{ 'assets/plugins/jquery/jquery-3.3.1.min.js'|theme }}\"></script>-->
    <script src=\"{{ 'assets/plugins/bootstrap/js/bootstrap.min.js'|theme }}\"></script>
    <script src=\"{{ 'assets/js/back-to-top.js'|theme }}\"></script>
    <script src=\"{{ 'assets/plugins/jquery-placeholder/jquery.placeholder.js'|theme }}\"></script>
    <script src=\"{{ 'assets/plugins/pretty-photo/js/jquery.prettyPhoto.js'|theme }}\"></script>
    <script src=\"{{ 'assets/plugins/flexslider/js/jquery.flexslider-min.js'|theme }}\"></script>
    <script src=\"{{ 'assets/js/jflickrfeed.min.js'|theme }}\"></script>
    <script src=\"{{ 'assets/js/main.js'|theme }}\"></script>

</head>
<body class=\"home-page\">

    <!-- Content -->
    <section id=\"layout-content\">
        <div class=\"wrapper\">
            {% partial 'site/header1' %}
            <div class=\"content container\">
                {% component 'SlideShow' %}
                <div class=\"row cols-wrapper\">
                    <div class=\"col-lg-9 col-12\">{% page %}</div>
                    <div class=\"col-lg-3 col-12\">{% partial 'site/navabar-right' %}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class=\"footer\">
        {% partial 'site/footer' %}
    </footer>

    <!-- Theme Switcher (REMOVE ON YOUR PRODUCTION SITE) -->
    <script src=\"{{ 'assets/js/theme-switcher.js'|theme }}\"></script>
    {% framework extras %}
    {% scripts %}

    <script type=\"text/javascript\">
\$(document).ready(function () {
    \$(\".carousel-item div.row\").click(function (e) {
        window.location.href = \"{{ url('actualites') }}/\" + \$(this).data('id');
    });
    
    \$(\".{{ active }}\").addClass(\"active\");

    \$(\".carousel-item div.row\").click(function (e) {
        window.location.href = \"{{ url('clubs-activites') }}/\" + \$(this).data('idclub');
    });

    /*('.link-mot-directeur').click(function(){
     console.log(\$(this).data('click'))
     
     });*/

    // alert(\"dsds\");

    /* ======= Flexslider ======= */
    \$('.flexslider').flexslider({
        animation: \"fade\"
    });

    /* ======= jQuery Placeholder ======= */
    \$('input, textarea').placeholder();


    /* ======= Carousels ======= */
    \$('#news-carousel').carousel({interval: false});
    \$('#videos-carousel').carousel({interval: false});
    \$('#testimonials-carousel').carousel({interval: 6000, pause: \"hover\"});
    \$('#awards-carousel').carousel({interval: false});


    /* ======= Flickr PhotoStream ======= */
    \$('#flickr-photos').jflickrfeed({
        limit: 12,
        qstrings: {
            id: '32104790@N02' /* Use idGettr.com to find the flickr user id */
        },
        itemTemplate:
                '<li>' +
                '<a rel=\"prettyPhoto[flickr]\" href=\"{{image}}\" title=\"{{title}}\">' +
                '<img src=\"{{image_s}}\" alt=\"{{title}}\" />' +
                '</a>' +
                '</li>'

    }, function (data) {
        \$('#flickr-photos a').prettyPhoto();
    });

    /* ======= Pretty Photo ======= */
    \$('a.prettyphoto').prettyPhoto();
});
    </script>
</body>
</html>", "/Applications/MAMP/htdocs/Sinai-school/themes/default/layouts/home.htm", "");
    }
}

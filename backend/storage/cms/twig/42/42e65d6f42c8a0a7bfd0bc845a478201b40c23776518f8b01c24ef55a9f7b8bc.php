<?php

/* /Applications/MAMP/htdocs/ayauka/backend/themes/default/partials/site/header1.htm */
class __TwigTemplate_8ee17f7c919250d71e2eefae94291f1d427f3ca4e5a8601b64808eaa65d14d34 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<header class=\"header\">
    <div class=\"top-bar\">
        <div class=\"container\">
            <div class=\"row\">
                <ul class=\"social-icons col-md-6 col-12 d-none d-md-block\">
                    <li><a href=\"#\"><i class=\"fab fa-twitter\"></i></a></li>
                    <li><a href=\"#\"><i class=\"fab fa-facebook-f\"></i></a></li>
                    <li><a href=\"#\"><i class=\"fab fa-youtube\"></i></a></li>
                    <li><a href=\"#\"><i class=\"fab fa-linkedin-in\"></i></a></li>
                    <li><a href=\"#\"><i class=\"fab fa-google-plus-g\"></i></a></li>
                    <li class=\"row-end\"><a href=\"#\"><i class=\"fas fa-rss\"></i></a></li>
                </ul>
                <form class=\"col-md-6 col-12 search-form\" role=\"search\">
                    <div class=\"form-group\">
                        <input type=\"text\" class=\"form-control\" placeholder=\"Rechercher sur le site ...\">
                    </div>
                    <button type=\"submit\" class=\"btn btn-theme\">Recherchez</button>
                </form>
            </div>
        </div>
    </div>
    <!--//to-bar-->

    <div class=\"header-main container\">
        <div class=\"row\">
            <h1 class=\"logo col-md-4 col-12\">
                <a href=\"";
        // line 27
        echo url("/");
        echo "\"><img id=\"logo\" style=\"width: 245px;height: 40px;\" src=\"";
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["parametrages"] ?? null), "logo", []), "html", null, true);
        echo "\"
                        alt=\"Logo\"></a>
            </h1>
            <!--//logo-->
            <div class=\"info col-md-8 col-12\">
                <ul class=\"menu-top float-right d-none d-md-block\">
                    <li class=\"divider\"><a href=\"";
        // line 33
        echo url("/");
        echo "\">Accueil</a></li>
                    <!-- <li class=\"divider\"><a href=\"faq.html\">FAQ</a></li> -->
                    <li><a href=\"";
        // line 35
        echo url("/contact");
        echo "\">Contact</a></li>
                </ul>
                <!--//menu-top-->
                <br />
                <div class=\"contact float-right\">
                    <p class=\"phone\"><i class=\"fas fa-phone\"></i>Appelez nous aujourd'hui au ";
        // line 40
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["parametrages"] ?? null), "number_front", []), "html", null, true);
        echo "</p>
                    <p class=\"email\"><i class=\"fas fa-envelope\"></i><a href=\"#\">";
        // line 41
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["parametrages"] ?? null), "email_front", []), "html", null, true);
        echo "</a></p>
                </div>
                <!--//contact-->
            </div>
            <!--//info-->
        </div>
        <!--//row-->
    </div>
    <!--//header-main-->
</header>

<div class=\"main-nav-wrapper\" id=\"main-nav-wrapper\">
    <div class=\"container\">
        <nav class=\"main-nav navbar navbar-expand-md\" role=\"navigation\">
            <button class=\"navbar-toggler collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbar-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <!--//nav-toggle-->

            <div class=\"navbar-collapse collapse\" id=\"navbar-collapse\">
                <ul class=\"nav navbar-nav\">
                    <li class=\"nav-item\"><a class=\"nav-link accueil\" href=\"";
        // line 65
        echo url("/");
        echo "\">Accueil</a></li>

                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle administration\" href=\"#\" id=\"navbarDropdown-1\" role=\"button\" data-toggle=\"dropdown\"
                            aria-haspopup=\"true\" aria-expanded=\"false\">Administration <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                            <a class=\"dropdown-item\" href=\"";
        // line 71
        echo url("/organigrame");
        echo "\">Organigrame</a>
                            <a class=\"dropdown-item\" href=\"";
        // line 72
        echo url("/examens");
        echo "\">Resultats et Examens</a>
                        </div>
                        <!--//dropdown-menu-->
                    </li>
                    
                    <li class=\"nav-item\"><a class=\"nav-link actualites\" href=\"";
        // line 77
        echo url("/actualites");
        echo "\">Actulités</a></li>
                    
<!--                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown-2\" role=\"button\" data-toggle=\"dropdown\"
                            aria-haspopup=\"true\" aria-expanded=\"false\">Enseignants <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown-2\">
                            <a class=\"dropdown-item\" href=\"";
        // line 83
        echo url("/professeurs");
        echo "\">Infos aux Enseignants</a>
                            <a class=\"dropdown-item\" href=\"";
        // line 84
        echo url("/activites-fin-trimestre");
        echo "\" style=\"width: 109%;\">Activités de
                                fin de trimestre</a>
                        </div>
                    </li>-->
                    
<!--                    <li class=\"nav-item\"><a class=\"nav-link\" href=\"";
        // line 89
        echo url("/reglement-interieur");
        echo "\">Règlement intérieur</a></li>-->
                                
                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle espaceeleve\" data-toggle=\"dropdown\" data-hover=\"dropdown\" data-delay=\"0\"
                            data-close-others=\"false\" href=\"#\">Espace Elèves <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\">
                            <a class=\"dropdown-item\" href=\"";
        // line 95
        echo url("/reglement-interieur");
        echo "\">Règlement intérieur</a>
                            <a class=\"dropdown-item\" href=\"";
        // line 96
        echo url("/activites-fin-trimestre");
        echo "\">Activités de
                                fin de trimestre</a>
<!--                            <a class=\"dropdown-item\" href=\"javascript:void(0)\">Infos aux élèves</a>
                            <a class=\"dropdown-item\" href=\"";
        // line 99
        echo url("/emplois-du-temps");
        echo "\">Emplois du temps eleve</a>
                            <a class=\"dropdown-item\" href=\"javascript:void(0)\">Devoirs de niveau</a>
                            <a class=\"dropdown-item\" href=\"";
        // line 101
        echo url("/sujets");
        echo "\">Bibliothèque numérique</a>-->
                        </div>
                    </li>
                    
                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle viescolaire\" data-toggle=\"dropdown\" data-hover=\"dropdown\" data-delay=\"0\"
                            data-close-others=\"false\" href=\"#\">Vie scolaire <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\">
                            <a class=\"dropdown-item\" href=\"";
        // line 109
        echo url("clubs-activites");
        echo "\">Clubs d'activités</a>
<!--                            <a class=\"dropdown-item\" href=\"javascript:void(0)\">Conseil scolaire</a>-->
                            <a class=\"dropdown-item\" href=\"";
        // line 111
        echo url("galeries");
        echo "\">Galerie</a>
                        </div>
                    </li>

<!--                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" data-hover=\"dropdown\" data-delay=\"0\"
                            data-close-others=\"false\" href=\"#\">Parents d'Elèves <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\">
                            <a class=\"dropdown-item\" href=\"";
        // line 119
        echo url("/suivre-mes-eleves");
        echo "\">Suivre mon élèves </a>
                             c'est programme qui a pour de suivre les moyennes de son enfant 
                            <a class=\"dropdown-item\" href=\"javascript:void(0)\">Notes-Moyennes-Bulletins</a>
                        </div>
                    </li>-->

                    <li class=\"nav-item\"><a class=\"nav-link contact\" href=\"";
        // line 125
        echo url("/contact");
        echo "\">Contact</a></li>
                </ul>
                <!--//nav-->
            </div>
            <!--//navabr-collapse-->

        </nav>
        <!--//main-nav-->
    </div>
    <!--//container-->
</div>";
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/ayauka/backend/themes/default/partials/site/header1.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  208 => 125,  199 => 119,  188 => 111,  183 => 109,  172 => 101,  167 => 99,  161 => 96,  157 => 95,  148 => 89,  140 => 84,  136 => 83,  127 => 77,  119 => 72,  115 => 71,  106 => 65,  79 => 41,  75 => 40,  67 => 35,  62 => 33,  51 => 27,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<header class=\"header\">
    <div class=\"top-bar\">
        <div class=\"container\">
            <div class=\"row\">
                <ul class=\"social-icons col-md-6 col-12 d-none d-md-block\">
                    <li><a href=\"#\"><i class=\"fab fa-twitter\"></i></a></li>
                    <li><a href=\"#\"><i class=\"fab fa-facebook-f\"></i></a></li>
                    <li><a href=\"#\"><i class=\"fab fa-youtube\"></i></a></li>
                    <li><a href=\"#\"><i class=\"fab fa-linkedin-in\"></i></a></li>
                    <li><a href=\"#\"><i class=\"fab fa-google-plus-g\"></i></a></li>
                    <li class=\"row-end\"><a href=\"#\"><i class=\"fas fa-rss\"></i></a></li>
                </ul>
                <form class=\"col-md-6 col-12 search-form\" role=\"search\">
                    <div class=\"form-group\">
                        <input type=\"text\" class=\"form-control\" placeholder=\"Rechercher sur le site ...\">
                    </div>
                    <button type=\"submit\" class=\"btn btn-theme\">Recherchez</button>
                </form>
            </div>
        </div>
    </div>
    <!--//to-bar-->

    <div class=\"header-main container\">
        <div class=\"row\">
            <h1 class=\"logo col-md-4 col-12\">
                <a href=\"{{ url('/') }}\"><img id=\"logo\" style=\"width: 245px;height: 40px;\" src=\"{{ parametrages.logo }}\"
                        alt=\"Logo\"></a>
            </h1>
            <!--//logo-->
            <div class=\"info col-md-8 col-12\">
                <ul class=\"menu-top float-right d-none d-md-block\">
                    <li class=\"divider\"><a href=\"{{ url('/') }}\">Accueil</a></li>
                    <!-- <li class=\"divider\"><a href=\"faq.html\">FAQ</a></li> -->
                    <li><a href=\"{{ url('/contact') }}\">Contact</a></li>
                </ul>
                <!--//menu-top-->
                <br />
                <div class=\"contact float-right\">
                    <p class=\"phone\"><i class=\"fas fa-phone\"></i>Appelez nous aujourd'hui au {{ parametrages.number_front }}</p>
                    <p class=\"email\"><i class=\"fas fa-envelope\"></i><a href=\"#\">{{ parametrages.email_front }}</a></p>
                </div>
                <!--//contact-->
            </div>
            <!--//info-->
        </div>
        <!--//row-->
    </div>
    <!--//header-main-->
</header>

<div class=\"main-nav-wrapper\" id=\"main-nav-wrapper\">
    <div class=\"container\">
        <nav class=\"main-nav navbar navbar-expand-md\" role=\"navigation\">
            <button class=\"navbar-toggler collapsed\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbar-collapse\">
                <span class=\"sr-only\">Toggle navigation</span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            <!--//nav-toggle-->

            <div class=\"navbar-collapse collapse\" id=\"navbar-collapse\">
                <ul class=\"nav navbar-nav\">
                    <li class=\"nav-item\"><a class=\"nav-link accueil\" href=\"{{ url('/') }}\">Accueil</a></li>

                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle administration\" href=\"#\" id=\"navbarDropdown-1\" role=\"button\" data-toggle=\"dropdown\"
                            aria-haspopup=\"true\" aria-expanded=\"false\">Administration <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                            <a class=\"dropdown-item\" href=\"{{ url('/organigrame') }}\">Organigrame</a>
                            <a class=\"dropdown-item\" href=\"{{ url('/examens') }}\">Resultats et Examens</a>
                        </div>
                        <!--//dropdown-menu-->
                    </li>
                    
                    <li class=\"nav-item\"><a class=\"nav-link actualites\" href=\"{{ url('/actualites') }}\">Actulités</a></li>
                    
<!--                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown-2\" role=\"button\" data-toggle=\"dropdown\"
                            aria-haspopup=\"true\" aria-expanded=\"false\">Enseignants <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown-2\">
                            <a class=\"dropdown-item\" href=\"{{ url('/professeurs') }}\">Infos aux Enseignants</a>
                            <a class=\"dropdown-item\" href=\"{{ url('/activites-fin-trimestre') }}\" style=\"width: 109%;\">Activités de
                                fin de trimestre</a>
                        </div>
                    </li>-->
                    
<!--                    <li class=\"nav-item\"><a class=\"nav-link\" href=\"{{ url('/reglement-interieur') }}\">Règlement intérieur</a></li>-->
                                
                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle espaceeleve\" data-toggle=\"dropdown\" data-hover=\"dropdown\" data-delay=\"0\"
                            data-close-others=\"false\" href=\"#\">Espace Elèves <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\">
                            <a class=\"dropdown-item\" href=\"{{ url('/reglement-interieur') }}\">Règlement intérieur</a>
                            <a class=\"dropdown-item\" href=\"{{ url('/activites-fin-trimestre') }}\">Activités de
                                fin de trimestre</a>
<!--                            <a class=\"dropdown-item\" href=\"javascript:void(0)\">Infos aux élèves</a>
                            <a class=\"dropdown-item\" href=\"{{ url('/emplois-du-temps') }}\">Emplois du temps eleve</a>
                            <a class=\"dropdown-item\" href=\"javascript:void(0)\">Devoirs de niveau</a>
                            <a class=\"dropdown-item\" href=\"{{ url('/sujets') }}\">Bibliothèque numérique</a>-->
                        </div>
                    </li>
                    
                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle viescolaire\" data-toggle=\"dropdown\" data-hover=\"dropdown\" data-delay=\"0\"
                            data-close-others=\"false\" href=\"#\">Vie scolaire <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\">
                            <a class=\"dropdown-item\" href=\"{{ url('clubs-activites')}}\">Clubs d'activités</a>
<!--                            <a class=\"dropdown-item\" href=\"javascript:void(0)\">Conseil scolaire</a>-->
                            <a class=\"dropdown-item\" href=\"{{ url('galeries')}}\">Galerie</a>
                        </div>
                    </li>

<!--                    <li class=\"nav-item dropdown\">
                        <a class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" data-hover=\"dropdown\" data-delay=\"0\"
                            data-close-others=\"false\" href=\"#\">Parents d'Elèves <i class=\"fas fa-angle-down\"></i></a>
                        <div class=\"dropdown-menu\">
                            <a class=\"dropdown-item\" href=\"{{ url('/suivre-mes-eleves') }}\">Suivre mon élèves </a>
                             c'est programme qui a pour de suivre les moyennes de son enfant 
                            <a class=\"dropdown-item\" href=\"javascript:void(0)\">Notes-Moyennes-Bulletins</a>
                        </div>
                    </li>-->

                    <li class=\"nav-item\"><a class=\"nav-link contact\" href=\"{{ url('/contact') }}\">Contact</a></li>
                </ul>
                <!--//nav-->
            </div>
            <!--//navabr-collapse-->

        </nav>
        <!--//main-nav-->
    </div>
    <!--//container-->
</div>", "/Applications/MAMP/htdocs/ayauka/backend/themes/default/partials/site/header1.htm", "");
    }
}

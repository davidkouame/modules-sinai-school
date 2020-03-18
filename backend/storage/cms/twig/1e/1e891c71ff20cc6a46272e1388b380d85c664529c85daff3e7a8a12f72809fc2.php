<?php

/* /Applications/MAMP/htdocs/ayauka/backend/themes/default/partials/site/footer.htm */
class __TwigTemplate_d3e8b0279f4107235b109f0dcaa120f9cc2c6998aa97c544c9bfc3936c5edb36 extends Twig_Template
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
        echo "<div class=\"footer-content\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"footer-col col-lg-3 col-md-4 col-12 no-padding-left-and-right about\">
                <div class=\"footer-col-inner no-padding-left-and-right\">
                    <h3>Administration</h3>
                    <ul>
                        <li><a href=\"";
        // line 8
        echo url("/organigrame");
        echo "\"><i class=\"fas fa-caret-right\"></i>Organigrame</a></li>
                        <li><a href=\"";
        // line 9
        echo url("/examens");
        echo "\"><i class=\"fas fa-caret-right\"></i>Resultats et examens</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"footer-col col-lg-3 col-md-4 col-12 no-padding-left-and-right about\">
                <div class=\"footer-col-inner no-padding-left-and-right\">
                    <h3>Espace Elèves</h3>
                    <ul>
                        <li><a href=\"";
        // line 17
        echo url("/reglement-interieur");
        echo "\"><i class=\"fas fa-caret-right\"></i>Règlement intérieur</a></li>
                        <li><a href=\"";
        // line 18
        echo url("/activites-fin-trimestre");
        echo "\"><i class=\"fas fa-caret-right\"></i>Activités de
                                fin de trimestre</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"footer-col col-lg-3 col-md-4 col-12 no-padding-left-and-right about\">
                <div class=\"footer-col-inner no-padding-left-and-right\">
                    <h3>Vie scolaire</h3>
                    <ul>
                        <li><a href=\"";
        // line 27
        echo url("clubs-activites");
        echo "\"><i class=\"fas fa-caret-right\"></i>Clubs d'activités</a></li>
                        <li><a href=\"";
        // line 28
        echo url("galeries");
        echo "\"><i class=\"fas fa-caret-right\"></i>Galerie</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"footer-col col-lg-3 col-md-4 col-12 no-padding-left-and-right about\">
                <div class=\"footer-col-inner no-padding-left-and-right\">
                    <div class=\"footer-col-inner\">
                        <h3 style=\"margin-bottom: 12px;\">Contactez-nous</h3>
                        <div class=\"row\">
                            <p class=\"tel col-lg-12 col-md-4 col-12\" style=\"margin-bottom: 4px;\"><i class=\"fas fa-phone\"></i>";
        // line 37
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["parametrages"] ?? null), "number_front", []), "html", null, true);
        echo "</p>
                            <p class=\"email col-lg-12 col-md-4 col-12\" style=\"margin-bottom: 14px;\"><i class=\"fas fa-envelope\"></i><a href=\"#\">";
        // line 38
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["parametrages"] ?? null), "email_front", []), "html", null, true);
        echo "</a></p>  
                        </div>
                    </div>            
                </div>  
            </div>
        </div>
        <div class=\"row justify-content-md-center\" style=\"margin-top: 10px;\">
            <div class=\"footer-col col-lg-8 col-md-4 col-12 no-padding-left-and-right newsletter\" style=\"position: relative;top: 34px;\">
                <div class=\"footer-col-inner no-padding-left-and-right\" style=\"text-align: center\">
                    <h3 style=\"margin-bottom: 2px;\">Joignez-vous à notre liste d'envoi</h3>
                    <p style=\"margin-bottom: 6px;border-bottom-width: 1px;\">Abonnez-vous pour recevoir notre lettre d'information</p>
                    <form class=\"subscribe-form\" data-request=\"onSuscriber\">
                        <div class=\"form-group\">
                            <input type=\"email\" class=\"form-control\" placeholder=\"Entrez votre mail\" name=\"email\"/>
                        </div>
                        <input class=\"btn btn-theme btn-subscribe\" type=\"submit\" value=\"Abonnez-vous\">
                    </form>
                </div>
            </div>
        </div>   
    </div>        
</div>
<div class=\"bottom-bar\">
    <div class=\"container\">
        <div class=\"row\">
            <small class=\"copyright col-lg-6 col-12\">Sinai 2019 @ <a href=\"http://www.sinai.com\">www.sinai.com</a></small>
            <ul class=\"social float-right col-lg-6 col-12\">
                <li><a href=\"#\" ><i class=\"fab fa-twitter\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-facebook-f\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-youtube\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-linkedin-in\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-google-plus-g\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-pinterest\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-skype\"></i></a></li> 
                <li class=\"row-end\"><a href=\"#\" ><i class=\"fas fa-rss\"></i></a></li>
            </ul><!--//social-->
        </div><!--//row-->
    </div><!--//container-->
</div><!--//bottom-bar-->";
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/ayauka/backend/themes/default/partials/site/footer.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  83 => 38,  79 => 37,  67 => 28,  63 => 27,  51 => 18,  47 => 17,  36 => 9,  32 => 8,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"footer-content\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"footer-col col-lg-3 col-md-4 col-12 no-padding-left-and-right about\">
                <div class=\"footer-col-inner no-padding-left-and-right\">
                    <h3>Administration</h3>
                    <ul>
                        <li><a href=\"{{ url('/organigrame') }}\"><i class=\"fas fa-caret-right\"></i>Organigrame</a></li>
                        <li><a href=\"{{ url('/examens') }}\"><i class=\"fas fa-caret-right\"></i>Resultats et examens</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"footer-col col-lg-3 col-md-4 col-12 no-padding-left-and-right about\">
                <div class=\"footer-col-inner no-padding-left-and-right\">
                    <h3>Espace Elèves</h3>
                    <ul>
                        <li><a href=\"{{ url('/reglement-interieur') }}\"><i class=\"fas fa-caret-right\"></i>Règlement intérieur</a></li>
                        <li><a href=\"{{ url('/activites-fin-trimestre') }}\"><i class=\"fas fa-caret-right\"></i>Activités de
                                fin de trimestre</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"footer-col col-lg-3 col-md-4 col-12 no-padding-left-and-right about\">
                <div class=\"footer-col-inner no-padding-left-and-right\">
                    <h3>Vie scolaire</h3>
                    <ul>
                        <li><a href=\"{{ url('clubs-activites')}}\"><i class=\"fas fa-caret-right\"></i>Clubs d'activités</a></li>
                        <li><a href=\"{{ url('galeries')}}\"><i class=\"fas fa-caret-right\"></i>Galerie</a></li>
                    </ul>
                </div>
            </div>
            <div class=\"footer-col col-lg-3 col-md-4 col-12 no-padding-left-and-right about\">
                <div class=\"footer-col-inner no-padding-left-and-right\">
                    <div class=\"footer-col-inner\">
                        <h3 style=\"margin-bottom: 12px;\">Contactez-nous</h3>
                        <div class=\"row\">
                            <p class=\"tel col-lg-12 col-md-4 col-12\" style=\"margin-bottom: 4px;\"><i class=\"fas fa-phone\"></i>{{ parametrages.number_front }}</p>
                            <p class=\"email col-lg-12 col-md-4 col-12\" style=\"margin-bottom: 14px;\"><i class=\"fas fa-envelope\"></i><a href=\"#\">{{ parametrages.email_front }}</a></p>  
                        </div>
                    </div>            
                </div>  
            </div>
        </div>
        <div class=\"row justify-content-md-center\" style=\"margin-top: 10px;\">
            <div class=\"footer-col col-lg-8 col-md-4 col-12 no-padding-left-and-right newsletter\" style=\"position: relative;top: 34px;\">
                <div class=\"footer-col-inner no-padding-left-and-right\" style=\"text-align: center\">
                    <h3 style=\"margin-bottom: 2px;\">Joignez-vous à notre liste d'envoi</h3>
                    <p style=\"margin-bottom: 6px;border-bottom-width: 1px;\">Abonnez-vous pour recevoir notre lettre d'information</p>
                    <form class=\"subscribe-form\" data-request=\"onSuscriber\">
                        <div class=\"form-group\">
                            <input type=\"email\" class=\"form-control\" placeholder=\"Entrez votre mail\" name=\"email\"/>
                        </div>
                        <input class=\"btn btn-theme btn-subscribe\" type=\"submit\" value=\"Abonnez-vous\">
                    </form>
                </div>
            </div>
        </div>   
    </div>        
</div>
<div class=\"bottom-bar\">
    <div class=\"container\">
        <div class=\"row\">
            <small class=\"copyright col-lg-6 col-12\">Sinai 2019 @ <a href=\"http://www.sinai.com\">www.sinai.com</a></small>
            <ul class=\"social float-right col-lg-6 col-12\">
                <li><a href=\"#\" ><i class=\"fab fa-twitter\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-facebook-f\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-youtube\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-linkedin-in\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-google-plus-g\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-pinterest\"></i></a></li>
                <li><a href=\"#\" ><i class=\"fab fa-skype\"></i></a></li> 
                <li class=\"row-end\"><a href=\"#\" ><i class=\"fas fa-rss\"></i></a></li>
            </ul><!--//social-->
        </div><!--//row-->
    </div><!--//container-->
</div><!--//bottom-bar-->", "/Applications/MAMP/htdocs/ayauka/backend/themes/default/partials/site/footer.htm", "");
    }
}

<?php

/* /Applications/MAMP/htdocs/Sinai-school/plugins/bootnetcrasher/school/components/contact/default.htm */
class __TwigTemplate_d259afd9a5e9460b02c7c3675c60f9b84cd0edaac038530fabbc6c26927c7fd9 extends Twig_Template
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
        $_type = isset($context["type"]) ? $context["type"] : null;        $_message = isset($context["message"]) ? $context["message"] : null;        // line 1
        $context["type"] = "success"        ;        foreach (Flash::success        () as $message) {
            $context["message"] = $message;            // line 2
            echo "    <div class=\"alert alert-success\">";
            echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
            echo "</div>
";
        }
        $context["type"] = $_type;        $context["message"] = $_message;        // line 4
        echo "<div class=\"page-wrapper\">
    <header class=\"page-heading clearfix\">
        <h1 class=\"heading-title pull-left\">Contact</h1>
        <!--        <div class=\"breadcrumbs pull-right\">
                    <ul class=\"breadcrumbs-list\">
                        <li class=\"breadcrumbs-label\">You are here:</li>
                        <li><a href=\"";
        // line 10
        echo url("/");
        echo "\">Home</a><i class=\"fa fa-angle-right\"></i></li>
                        <li class=\"current\">Contact</li>
                    </ul>
                </div>//breadcrumbs-->
    </header> 
    <div class=\"page-content\">
        <div class=\"row\">
            <article class=\"contact-form col-md-9 col-sm-7  page-row\">                            
                <h3 class=\"title\">Contactez-nous</h3>
                <p>We’d love to hear from you. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ut erat magna. Aliquam porta sem a lacus imperdiet posuere. Integer semper eget ligula id eleifend. </p>
                <form data-request=\"onSendmail\"  data-request-files data-request-flash>
                    <div class=\"form-group name\">
                        <label for=\"name\">Nom et prénom</label>
                        <input id=\"name\" type=\"text\" class=\"form-control\" name=\"nom_prenom\" placeholder=\"Entrez votre nom et prénoms\">
                    </div><!--//form-group-->
                    <div class=\"form-group email\">
                        <label for=\"email\">Email<span class=\"required\">*</span></label>
                        <input id=\"email\" type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Entrez votre email\">
                    </div><!--//form-group-->
                    <div class=\"form-group phone\">
                        <label for=\"phone\">Téléphone</label>
                        <input id=\"phone\" type=\"tel\" class=\"form-control\" name=\"telephone\" placeholder=\"Entrez votre contact\">
                    </div><!--//form-group-->
                    <div class=\"form-group message\">
                        <label for=\"message\">Message<span class=\"required\">*</span></label>
                        <textarea id=\"message\" class=\"form-control\" rows=\"6\" name=\"message\" placeholder=\"Entrez votre message ici ...\"></textarea>
                    </div><!--//form-group-->
                    <button type=\"submit\" class=\"btn btn-theme\">Envoyer</button>
                </form>                  
            </article><!--//contact-form-->
            <aside class=\"page-sidebar  col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-1\">
                <section class=\"widget has-divider\">
                    <h3 class=\"title\">Télécharger le prospectus</h3>
                    <p>Donec pulvinar arcu lacus, vel aliquam libero scelerisque a. Cras mi tellus, vulputate eu eleifend at, consectetur fringilla lacus. Nulla ut purus.</p>
                    <a class=\"btn btn-theme\" href=\"";
        // line 44
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["prospectus"] ?? null), "logo", []), "getpath", []), "html", null, true);
        echo "\" target=\"__blank\"><i class=\"fa fa-download\"></i>Télécharger</a>
                </section><!--//widget-->   

                <section class=\"widget has-divider\">
                    <h3 class=\"title\">Adresse postale</h3>
                    <p class=\"adr\">
                        <span class=\"adr-group\">       
                            <span class=\"street-address\">";
        // line 51
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["nom_ecole"] ?? null), "value", []), "html", null, true);
        echo "</span><br>
                            <!--                            <span class=\"region\">56 College Green Road</span><br>-->
                            <span class=\"postal-code\">";
        // line 53
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["adresse_postale_ecole"] ?? null), "value", []), "html", null, true);
        echo "</span><br>
                            <!--                            <span class=\"country-name\">UK</span>-->
                        </span>
                    </p>
                </section><!--//widget-->     

                <section class=\"widget\">
                    <h3 class=\"title\">Contacts</h3>
                    <p class=\"tel\"><i class=\"fa fa-phone\"></i>Tel: ";
        // line 61
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["tel_ecole"] ?? null), "value", []), "html", null, true);
        echo "</p>
                    <p class=\"email\"><i class=\"fa fa-envelope\"></i>Email: <a href=\"#\">";
        // line 62
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["email_ecole"] ?? null), "value", []), "html", null, true);
        echo "</a></p>
                </section>   
            </aside><!--//page-sidebar-->
        </div><!--//page-row-->
        <div class=\"page-row\">
            <article class=\"map-section\">
                <h3 class=\"title\">Comment nous trouvez ?</h3>
                <div class=\"gmap-wrapper\" id=\"map\">
                    <!--//You need to embed your own google map below-->
                    <!--//Ref: https://support.google.com/maps/answer/144361?co=GENIE.Platform%3DDesktop&hl=en -->
                    <iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2485.985798395094!2d-2.6051732483185885!3d51.458417179527075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48718ddbdfd292fb%3A0x2f0b60f89b4b6d56!2sUniversity+of+Bristol!5e0!3m2!1sen!2suk!4v1469704137699\" style=\"border:0\" allowfullscreen=\"\" width=\"600\" height=\"450\" frameborder=\"0\"></iframe>
                </div><!--//gmap-wrapper-->
            </article><!--//map-->
        </div><!--//page-row-->
    </div><!--//page-content-->
</div>";
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/Sinai-school/plugins/bootnetcrasher/school/components/contact/default.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 62,  102 => 61,  91 => 53,  86 => 51,  76 => 44,  39 => 10,  31 => 4,  25 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% flash success %}
    <div class=\"alert alert-success\">{{ message }}</div>
{% endflash %}
<div class=\"page-wrapper\">
    <header class=\"page-heading clearfix\">
        <h1 class=\"heading-title pull-left\">Contact</h1>
        <!--        <div class=\"breadcrumbs pull-right\">
                    <ul class=\"breadcrumbs-list\">
                        <li class=\"breadcrumbs-label\">You are here:</li>
                        <li><a href=\"{{ url('/') }}\">Home</a><i class=\"fa fa-angle-right\"></i></li>
                        <li class=\"current\">Contact</li>
                    </ul>
                </div>//breadcrumbs-->
    </header> 
    <div class=\"page-content\">
        <div class=\"row\">
            <article class=\"contact-form col-md-9 col-sm-7  page-row\">                            
                <h3 class=\"title\">Contactez-nous</h3>
                <p>We’d love to hear from you. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ut erat magna. Aliquam porta sem a lacus imperdiet posuere. Integer semper eget ligula id eleifend. </p>
                <form data-request=\"onSendmail\"  data-request-files data-request-flash>
                    <div class=\"form-group name\">
                        <label for=\"name\">Nom et prénom</label>
                        <input id=\"name\" type=\"text\" class=\"form-control\" name=\"nom_prenom\" placeholder=\"Entrez votre nom et prénoms\">
                    </div><!--//form-group-->
                    <div class=\"form-group email\">
                        <label for=\"email\">Email<span class=\"required\">*</span></label>
                        <input id=\"email\" type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Entrez votre email\">
                    </div><!--//form-group-->
                    <div class=\"form-group phone\">
                        <label for=\"phone\">Téléphone</label>
                        <input id=\"phone\" type=\"tel\" class=\"form-control\" name=\"telephone\" placeholder=\"Entrez votre contact\">
                    </div><!--//form-group-->
                    <div class=\"form-group message\">
                        <label for=\"message\">Message<span class=\"required\">*</span></label>
                        <textarea id=\"message\" class=\"form-control\" rows=\"6\" name=\"message\" placeholder=\"Entrez votre message ici ...\"></textarea>
                    </div><!--//form-group-->
                    <button type=\"submit\" class=\"btn btn-theme\">Envoyer</button>
                </form>                  
            </article><!--//contact-form-->
            <aside class=\"page-sidebar  col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-1\">
                <section class=\"widget has-divider\">
                    <h3 class=\"title\">Télécharger le prospectus</h3>
                    <p>Donec pulvinar arcu lacus, vel aliquam libero scelerisque a. Cras mi tellus, vulputate eu eleifend at, consectetur fringilla lacus. Nulla ut purus.</p>
                    <a class=\"btn btn-theme\" href=\"{{ prospectus.logo.getpath }}\" target=\"__blank\"><i class=\"fa fa-download\"></i>Télécharger</a>
                </section><!--//widget-->   

                <section class=\"widget has-divider\">
                    <h3 class=\"title\">Adresse postale</h3>
                    <p class=\"adr\">
                        <span class=\"adr-group\">       
                            <span class=\"street-address\">{{ nom_ecole.value }}</span><br>
                            <!--                            <span class=\"region\">56 College Green Road</span><br>-->
                            <span class=\"postal-code\">{{ adresse_postale_ecole.value }}</span><br>
                            <!--                            <span class=\"country-name\">UK</span>-->
                        </span>
                    </p>
                </section><!--//widget-->     

                <section class=\"widget\">
                    <h3 class=\"title\">Contacts</h3>
                    <p class=\"tel\"><i class=\"fa fa-phone\"></i>Tel: {{ tel_ecole.value }}</p>
                    <p class=\"email\"><i class=\"fa fa-envelope\"></i>Email: <a href=\"#\">{{ email_ecole.value }}</a></p>
                </section>   
            </aside><!--//page-sidebar-->
        </div><!--//page-row-->
        <div class=\"page-row\">
            <article class=\"map-section\">
                <h3 class=\"title\">Comment nous trouvez ?</h3>
                <div class=\"gmap-wrapper\" id=\"map\">
                    <!--//You need to embed your own google map below-->
                    <!--//Ref: https://support.google.com/maps/answer/144361?co=GENIE.Platform%3DDesktop&hl=en -->
                    <iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2485.985798395094!2d-2.6051732483185885!3d51.458417179527075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48718ddbdfd292fb%3A0x2f0b60f89b4b6d56!2sUniversity+of+Bristol!5e0!3m2!1sen!2suk!4v1469704137699\" style=\"border:0\" allowfullscreen=\"\" width=\"600\" height=\"450\" frameborder=\"0\"></iframe>
                </div><!--//gmap-wrapper-->
            </article><!--//map-->
        </div><!--//page-row-->
    </div><!--//page-content-->
</div>", "/Applications/MAMP/htdocs/Sinai-school/plugins/bootnetcrasher/school/components/contact/default.htm", "");
    }
}

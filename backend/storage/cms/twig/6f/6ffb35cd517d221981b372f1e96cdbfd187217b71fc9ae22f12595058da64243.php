<?php

/* /var/www/html/modules-sinai-school/backend/themes/default/partials/site/mot-du-directeur.htm */
class __TwigTemplate_26c04b262a538f0871c6e0d9962b49dff139266a3865250ebc6a67e94a14cf93 extends Twig_Template
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
        echo "<a href=\"";
        echo url("/mot-du-directeur");
        echo "\" class=\"testimonials link-mot-directeur\" style=\"margin-bottom: 28px;margin-top: 28px\" >
    <h1 class=\"section-heading text-highlight\" style=\"border-top: 2px solid #6091ba;\"><span class=\"line\"style=\"border-top: 0;\"> Mot du directeur</span></h1>
    <!--<div class=\"carousel-controls\">
          <a class=\"prev\" href=\"#testimonials-carousel\" data-slide=\"prev\"><i class=\"fas fa-caret-left\"></i></a>
          <a class=\"next\" href=\"#testimonials-carousel\" data-slide=\"next\"><i class=\"fas fa-caret-right\"></i></a>
      </div>-->
    <!--//carousel-controls-->
    <div class=\"section-content\">
        <div class=\"testimonials-carousel carousel slide\">
            <div class=\"carousel-inner\">
                <div class=\"carousel-item item active\" style='min-height: 188px;'>
                    <blockquote class=\"quote\">
                        <p>
                            <i class=\"fas fa-quote-left\"></i>";
        // line 14
        echo call_user_func_array($this->env->getFilter('truncate')->getCallable(), ["I’m very happy interdum eget ipsum. Nunc pulvinar ut nulla eget sollicitudin. In hac habitasse platea dictumst. Duis luctus snfjdnsfjds", 179, "..."]);
        echo "</p>
                    </blockquote>
                    <div class=\"source\" style='padding-top: 4px;'>
                        <p class=\"people\"><span class=\"name\">Marissa Spencerddsds</span><br /><span class=\"title\">Directeur
                                </span></p>
                        <img class=\"profile\" src=\"";
        // line 19
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/images/profile-1.png");
        echo "\"
                             alt=\"\" style=\"border: 0px;right: 0px;\" />
                    </div>
                </div>
                <!--//item-->
            </div>
            <!--//carousel-inner-->
        </div>
        <!--//testimonials-carousel-->
    </div>
    <!--//section-content-->
</a>";
    }

    public function getTemplateName()
    {
        return "/var/www/html/modules-sinai-school/backend/themes/default/partials/site/mot-du-directeur.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 19,  40 => 14,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<a href=\"{{url('/mot-du-directeur')}}\" class=\"testimonials link-mot-directeur\" style=\"margin-bottom: 28px;margin-top: 28px\" >
    <h1 class=\"section-heading text-highlight\" style=\"border-top: 2px solid #6091ba;\"><span class=\"line\"style=\"border-top: 0;\"> Mot du directeur</span></h1>
    <!--<div class=\"carousel-controls\">
          <a class=\"prev\" href=\"#testimonials-carousel\" data-slide=\"prev\"><i class=\"fas fa-caret-left\"></i></a>
          <a class=\"next\" href=\"#testimonials-carousel\" data-slide=\"next\"><i class=\"fas fa-caret-right\"></i></a>
      </div>-->
    <!--//carousel-controls-->
    <div class=\"section-content\">
        <div class=\"testimonials-carousel carousel slide\">
            <div class=\"carousel-inner\">
                <div class=\"carousel-item item active\" style='min-height: 188px;'>
                    <blockquote class=\"quote\">
                        <p>
                            <i class=\"fas fa-quote-left\"></i>{{ \"I’m very happy interdum eget ipsum. Nunc pulvinar ut nulla eget sollicitudin. In hac habitasse platea dictumst. Duis luctus snfjdnsfjds\" |truncate(179, '...')}}</p>
                    </blockquote>
                    <div class=\"source\" style='padding-top: 4px;'>
                        <p class=\"people\"><span class=\"name\">Marissa Spencerddsds</span><br /><span class=\"title\">Directeur
                                </span></p>
                        <img class=\"profile\" src=\"{{ 'assets/images/profile-1.png'|theme}}\"
                             alt=\"\" style=\"border: 0px;right: 0px;\" />
                    </div>
                </div>
                <!--//item-->
            </div>
            <!--//carousel-inner-->
        </div>
        <!--//testimonials-carousel-->
    </div>
    <!--//section-content-->
</a>", "/var/www/html/modules-sinai-school/backend/themes/default/partials/site/mot-du-directeur.htm", "");
    }
}

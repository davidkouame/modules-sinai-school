<?php

/* /Applications/MAMP/htdocs/modules-sinai-school/backend/plugins/bootnetcrasher/school/components/actualites/default.htm */
class __TwigTemplate_6c3e7b7799c36a44edb8fe824e85429dadc93ae3f989f357694df33cf3063487 extends Twig_Template
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
        echo "<div class=\"row\">
<div class=\"col-lg-12 col-12\">
    <section class=\"news\">
        <div class='section-header clearfix'>
            <div class=\"col-md-12\">
                <div class=\"row\" style=\"padding-bottom: 5px;border-bottom: 2px #e2e2e2 solid;margin-bottom: 20px;\">
                    <div class=\"col-lg-9\" style=\"padding-left: 0px;\">
                        <h1 class=\"section-title title col-md-2\" style=\"font-size: 1.2rem;padding-left: 0px;margin-bottom: 0px;\">Actualités</h1>
                    </div>
                    <div class=\"col-lg-3\" style=\"padding-right: 0px;\">
                        <a class=\"read-more float-right\" href=\"";
        // line 11
        echo url("actualites");
        echo "\">Voir toutes les actualités<i class=\"fa fa-chevron-right\"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"section-content clearfix\" style=\"padding-left: 0px;padding-bottom: 0px;\">
            <div id=\"news-carousel\" class=\"news-carousel carousel slide\">
                <div class=\"carousel-inner\">

                    ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["actualites"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["actualite"]) {
            // line 21
            echo "                        <div class=\"item carousel-item active\">
                            <div class=\"row\" data-id=\"";
            // line 22
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["actualite"], "id", []), "html", null, true);
            echo "\">
                                <div class=\"col-lg-3\">
                                    <figure class='jss374' style='background-image: url(\"";
            // line 24
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["actualite"], "cover", []), "getpath", []), "html", null, true);
            echo "\");'></figure>
                                </div>
                                <div class=\"col-lg-9\">
                                    <h2 class=\"title\"><a href=\"";
            // line 27
            echo url("/actualites");
            echo "/";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["actualite"], "id", []), "html", null, true);
            echo "\" style=\"color: #6091ba;\">";
            echo call_user_func_array($this->env->getFilter('truncate')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["actualite"], "title", []), 142, false, " ..."]);
            echo "</a></h2>
                                    <p>
                                        ";
            // line 29
            echo call_user_func_array($this->env->getFilter('truncate')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["actualite"], "content", []), 235, false, " ..."]);
            echo "
                                    </p>
                                </div>
                            </div>
                        </div>

                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['actualite'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        echo "
                </div>
            </div>

            <!--<div class=\"pagination\" style=\"margin-bottom: 0px;margin-top: 0px;\">
                ";
        // line 41
        echo ($context["actualites"] ?? null);
        echo "
            </div>-->

        </div>
    </section>
</div></div>";
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/modules-sinai-school/backend/plugins/bootnetcrasher/school/components/actualites/default.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 41,  87 => 36,  74 => 29,  65 => 27,  59 => 24,  54 => 22,  51 => 21,  47 => 20,  35 => 11,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"row\">
<div class=\"col-lg-12 col-12\">
    <section class=\"news\">
        <div class='section-header clearfix'>
            <div class=\"col-md-12\">
                <div class=\"row\" style=\"padding-bottom: 5px;border-bottom: 2px #e2e2e2 solid;margin-bottom: 20px;\">
                    <div class=\"col-lg-9\" style=\"padding-left: 0px;\">
                        <h1 class=\"section-title title col-md-2\" style=\"font-size: 1.2rem;padding-left: 0px;margin-bottom: 0px;\">Actualités</h1>
                    </div>
                    <div class=\"col-lg-3\" style=\"padding-right: 0px;\">
                        <a class=\"read-more float-right\" href=\"{{ url('actualites') }}\">Voir toutes les actualités<i class=\"fa fa-chevron-right\"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"section-content clearfix\" style=\"padding-left: 0px;padding-bottom: 0px;\">
            <div id=\"news-carousel\" class=\"news-carousel carousel slide\">
                <div class=\"carousel-inner\">

                    {% for actualite in actualites %}
                        <div class=\"item carousel-item active\">
                            <div class=\"row\" data-id=\"{{ actualite.id }}\">
                                <div class=\"col-lg-3\">
                                    <figure class='jss374' style='background-image: url(\"{{ actualite.cover.getpath }}\");'></figure>
                                </div>
                                <div class=\"col-lg-9\">
                                    <h2 class=\"title\"><a href=\"{{ url('/actualites') }}/{{ actualite.id }}\" style=\"color: #6091ba;\">{{ actualite.title|truncate(142, false, \" ...\") }}</a></h2>
                                    <p>
                                        {{ actualite.content|truncate(235, false, \" ...\") }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    {% endfor %}

                </div>
            </div>

            <!--<div class=\"pagination\" style=\"margin-bottom: 0px;margin-top: 0px;\">
                {{ actualites|raw}}
            </div>-->

        </div>
    </section>
</div></div>", "/Applications/MAMP/htdocs/modules-sinai-school/backend/plugins/bootnetcrasher/school/components/actualites/default.htm", "");
    }
}

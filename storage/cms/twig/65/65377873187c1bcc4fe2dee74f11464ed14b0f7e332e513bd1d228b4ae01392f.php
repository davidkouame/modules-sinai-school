<?php

/* /Applications/MAMP/htdocs/Sinai-school/themes/default/partials/site/navabar-right.htm */
class __TwigTemplate_525a29cc5d4460beffcb28910f3cd3f35479fbe45980fa38547e739db5034a4c extends Twig_Template
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
        echo "<!--Navabar right -> {mot du directeur, majeur de la promotion-->
<div class=\"row\">
    <div class=\"col-lg-12 col-12\" style=\"margin-top: 38px;\" id=\"navabar-right\">
    ";
        // line 4
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->partialFunction("site/mot-du-directeur"        , $context['__cms_partial_params']        , true        );
        unset($context['__cms_partial_params']);
        // line 5
        echo "
    ";
        // line 6
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->partialFunction("site/majeur-promotion"        , $context['__cms_partial_params']        , true        );
        unset($context['__cms_partial_params']);
        // line 7
        echo "</div>
</div>";
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/Sinai-school/themes/default/partials/site/navabar-right.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 7,  35 => 6,  32 => 5,  28 => 4,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!--Navabar right -> {mot du directeur, majeur de la promotion-->
<div class=\"row\">
    <div class=\"col-lg-12 col-12\" style=\"margin-top: 38px;\" id=\"navabar-right\">
    {% partial 'site/mot-du-directeur' %}

    {% partial 'site/majeur-promotion' %}
</div>
</div>", "/Applications/MAMP/htdocs/Sinai-school/themes/default/partials/site/navabar-right.htm", "");
    }
}

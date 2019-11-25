<?php

/* /Applications/MAMP/htdocs/modules-sinai-school/backend/themes/default/pages/home.htm */
class __TwigTemplate_ac100a6254e2ff89dc0dca629ce93c98060daa37239056cf348f155fc09e2ba3 extends Twig_Template
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
        echo "<style>
        margin-top: 28px;
</style>
";
        // line 4
        $context['__cms_component_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->componentFunction("actualites"        , $context['__cms_component_params']        );
        unset($context['__cms_component_params']);
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/modules-sinai-school/backend/themes/default/pages/home.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 4,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<style>
        margin-top: 28px;
</style>
{% component 'actualites' %}", "/Applications/MAMP/htdocs/modules-sinai-school/backend/themes/default/pages/home.htm", "");
    }
}

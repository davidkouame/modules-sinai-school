<?php

/* /Applications/MAMP/htdocs/ayauka/backend/themes/default/pages/home.htm */
class __TwigTemplate_b3107ea5e62b32e5549ea3927c4eb4c2f25e1784bac5bf7545e3606633bfd15e extends Twig_Template
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
        return "/Applications/MAMP/htdocs/ayauka/backend/themes/default/pages/home.htm";
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
{% component 'actualites' %}", "/Applications/MAMP/htdocs/ayauka/backend/themes/default/pages/home.htm", "");
    }
}

<?php

/* /Applications/MAMP/htdocs/modules-sinai-school/backend/themes/default/partials/site/majeur-promotion.htm */
class __TwigTemplate_87717fd63522e82e18d10e443d2b8465d52552d0af6e21b204d270a015853b7a extends Twig_Template
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
    #year span{
        font-size: 21px;
        color: #444444;
        font-weight: bold;
        margin-top: 2%;
    }
</style>

<section class=\"testimonials\">
    <h1 class=\"section-heading text-highlight\" style=\"border-top: 2px solid #6091ba;\"><span class=\"line\" style='font-size: 18px;border: 0;font-size: 22px;font-weight: 300;line-height: 2;color: #2f506c;'>Majeur de
            promotion</span></h1>
    <h3 class=\"section-heading text-highlight\" style='margin-bottom: 4px;margin-top: -31px;text-align: center;'>
        <span class=\"line\" style='font-size: 15px;color: #444444;'>Didja Kobenan .</span>
    </h3>
    <a target=\"_blank\" href=\"img_forest.jpg\">
        <img src=\"";
        // line 17
        echo $this->extensions['Cms\Twig\Extension']->themeFilter("assets/images/majeur-promotion.jpg");
        echo "\" alt=\"Forest\" style=\"width: 100%;max-height: 170px;\">
    </a>
    <div id=\"year\" class=\"row\"><span class=\"col-md-12 text-center\">2017-2018</span></div>
</section>";
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/modules-sinai-school/backend/themes/default/partials/site/majeur-promotion.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 17,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<style>
    #year span{
        font-size: 21px;
        color: #444444;
        font-weight: bold;
        margin-top: 2%;
    }
</style>

<section class=\"testimonials\">
    <h1 class=\"section-heading text-highlight\" style=\"border-top: 2px solid #6091ba;\"><span class=\"line\" style='font-size: 18px;border: 0;font-size: 22px;font-weight: 300;line-height: 2;color: #2f506c;'>Majeur de
            promotion</span></h1>
    <h3 class=\"section-heading text-highlight\" style='margin-bottom: 4px;margin-top: -31px;text-align: center;'>
        <span class=\"line\" style='font-size: 15px;color: #444444;'>Didja Kobenan .</span>
    </h3>
    <a target=\"_blank\" href=\"img_forest.jpg\">
        <img src=\"{{ 'assets/images/majeur-promotion.jpg'|theme}}\" alt=\"Forest\" style=\"width: 100%;max-height: 170px;\">
    </a>
    <div id=\"year\" class=\"row\"><span class=\"col-md-12 text-center\">2017-2018</span></div>
</section>", "/Applications/MAMP/htdocs/modules-sinai-school/backend/themes/default/partials/site/majeur-promotion.htm", "");
    }
}

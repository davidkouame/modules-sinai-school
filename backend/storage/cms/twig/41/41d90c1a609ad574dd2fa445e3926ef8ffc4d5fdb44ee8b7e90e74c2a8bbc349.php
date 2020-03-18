<?php

/* /Applications/MAMP/htdocs/ayauka/backend/plugins/bootnetcrasher/slideshow/components/slideshow/default.htm */
class __TwigTemplate_53c7ecff991ab9fcd4d907148cdbaaff6ae56518466f6bb8dc2a419fd23b9ba5 extends Twig_Template
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
        echo "<style type=\"text/css\">
    .flex-control-nav.flex-control-paging{
        position: unset;
    }
</style>
<div id=\"promo-slider\" class=\"slider flexslider\" style='margin-bottom: 23px;'>
    <ul class=\"slides\">
        ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["slideshows"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["slideshow"]) {
            // line 9
            echo "            <li>
                <img src=\"";
            // line 10
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["slideshow"], "slide", []), "getpath", []), "html", null, true);
            echo "\" alt=\"\" />
                <p class=\"flex-caption\">
                    <p class=\"flex-caption\">
                        ";
            // line 13
            if (twig_get_attribute($this->env, $this->source, $context["slideshow"], "title_cover", [])) {
                // line 14
                echo "                            <span class=\"main\">
                                ";
                // line 15
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["slideshow"], "title_cover", []), "html", null, true);
                echo "
                            </span>
                            <br>
                        ";
            }
            // line 19
            echo "                        ";
            if (twig_get_attribute($this->env, $this->source, $context["slideshow"], "description_cover", [])) {
                // line 20
                echo "                            <span class=\"secondary clearfix\">
                                ";
                // line 21
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["slideshow"], "description_cover", []), "html", null, true);
                echo "
                            </span>
                        ";
            }
            // line 24
            echo "                    </p>
                </p>
            </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['slideshow'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo "    </ul>
</div>";
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/ayauka/backend/plugins/bootnetcrasher/slideshow/components/slideshow/default.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 28,  69 => 24,  63 => 21,  60 => 20,  57 => 19,  50 => 15,  47 => 14,  45 => 13,  39 => 10,  36 => 9,  32 => 8,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<style type=\"text/css\">
    .flex-control-nav.flex-control-paging{
        position: unset;
    }
</style>
<div id=\"promo-slider\" class=\"slider flexslider\" style='margin-bottom: 23px;'>
    <ul class=\"slides\">
        {% for slideshow in slideshows %}
            <li>
                <img src=\"{{ slideshow.slide.getpath  }}\" alt=\"\" />
                <p class=\"flex-caption\">
                    <p class=\"flex-caption\">
                        {% if slideshow.title_cover %}
                            <span class=\"main\">
                                {{ slideshow.title_cover }}
                            </span>
                            <br>
                        {% endif %}
                        {% if slideshow.description_cover %}
                            <span class=\"secondary clearfix\">
                                {{ slideshow.description_cover }}
                            </span>
                        {% endif %}
                    </p>
                </p>
            </li>
        {% endfor %}
    </ul>
</div>", "/Applications/MAMP/htdocs/ayauka/backend/plugins/bootnetcrasher/slideshow/components/slideshow/default.htm", "");
    }
}

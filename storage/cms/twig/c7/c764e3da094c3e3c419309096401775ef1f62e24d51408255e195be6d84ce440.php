<?php

/* /Applications/MAMP/htdocs/module-sinai-school/plugins/rainlab/user/components/account/register.htm */
class __TwigTemplate_0e1a6dd2654487e387adb695f183361c623ed69941f10f724387faedff845d75 extends Twig_Template
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
        if (($context["canRegister"] ?? null)) {
            // line 2
            echo "    <h3>Register</h3>
    <form
        data-request=\"onRegister\">
        <div class=\"form-group\">
            <label for=\"registerName\">Full Name</label>
            <input
                name=\"name\"
                type=\"text\"
                class=\"form-control\"
                id=\"registerName\"
                placeholder=\"Enter your full name\" />
        </div>

        <div class=\"form-group\">
            <label for=\"registerEmail\">Email</label>
            <input
                name=\"email\"
                type=\"email\"
                class=\"form-control\"
                id=\"registerEmail\"
                placeholder=\"Enter your email\" />
        </div>

        ";
            // line 25
            if ((($context["loginAttribute"] ?? null) == "username")) {
                // line 26
                echo "            <div class=\"form-group\">
                <label for=\"registerUsername\">Username</label>
                <input
                    name=\"username\"
                    type=\"text\"
                    class=\"form-control\"
                    id=\"registerUsername\"
                    placeholder=\"Enter your username\" />
            </div>
        ";
            }
            // line 36
            echo "
        <div class=\"form-group\">
            <label for=\"registerPassword\">Password</label>
            <input
                name=\"password\"
                type=\"password\"
                class=\"form-control\"
                id=\"registerPassword\"
                placeholder=\"Choose a password\" />
        </div>

        <button type=\"submit\" class=\"btn btn-default\">Register</button>
    </form>
";
        } else {
            // line 50
            echo "    <!-- Registration is disabled. -->
";
        }
    }

    public function getTemplateName()
    {
        return "/Applications/MAMP/htdocs/module-sinai-school/plugins/rainlab/user/components/account/register.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  80 => 50,  64 => 36,  52 => 26,  50 => 25,  25 => 2,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% if canRegister %}
    <h3>Register</h3>
    <form
        data-request=\"onRegister\">
        <div class=\"form-group\">
            <label for=\"registerName\">Full Name</label>
            <input
                name=\"name\"
                type=\"text\"
                class=\"form-control\"
                id=\"registerName\"
                placeholder=\"Enter your full name\" />
        </div>

        <div class=\"form-group\">
            <label for=\"registerEmail\">Email</label>
            <input
                name=\"email\"
                type=\"email\"
                class=\"form-control\"
                id=\"registerEmail\"
                placeholder=\"Enter your email\" />
        </div>

        {% if loginAttribute == \"username\" %}
            <div class=\"form-group\">
                <label for=\"registerUsername\">Username</label>
                <input
                    name=\"username\"
                    type=\"text\"
                    class=\"form-control\"
                    id=\"registerUsername\"
                    placeholder=\"Enter your username\" />
            </div>
        {% endif %}

        <div class=\"form-group\">
            <label for=\"registerPassword\">Password</label>
            <input
                name=\"password\"
                type=\"password\"
                class=\"form-control\"
                id=\"registerPassword\"
                placeholder=\"Choose a password\" />
        </div>

        <button type=\"submit\" class=\"btn btn-default\">Register</button>
    </form>
{% else %}
    <!-- Registration is disabled. -->
{% endif %}
", "/Applications/MAMP/htdocs/module-sinai-school/plugins/rainlab/user/components/account/register.htm", "");
    }
}

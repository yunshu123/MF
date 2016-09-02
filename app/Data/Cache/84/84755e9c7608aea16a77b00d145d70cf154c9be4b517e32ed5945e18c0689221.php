<?php

/* index/index.php */
class __TwigTemplate_0fa6eb70fe2b7e985ffad742c6ff8632946e4184c8a20e21a58611141541efaa extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "name", array()), "html", null, true);
        echo "-- ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["data"]) ? $context["data"] : null), "age", array()), "html", null, true);
    }

    public function getTemplateName()
    {
        return "index/index.php";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
/* {{ data.name }}-- {{data.age}}*/

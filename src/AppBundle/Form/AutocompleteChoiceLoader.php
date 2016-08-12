<?php
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;

class AutocompleteChoiceLoader implements ChoiceLoaderInterface
{
    /** @var ChoiceListInterface */
    private $choiceList;

    public function loadValuesForChoices(array $choices, $value = null)
    {
        // is called on form creat with $choices containing the preset of the bound entity
        $values = array('--');
        foreach ($choices as $key => $choice) {
            // we use a DataTransformer, thus only plain values arrive as choices which can be used directly as value
            if (is_callable($value)) {
                $values[$key] = (string)call_user_func($value, $choice, $key);
            }
            else {
                $values[$key] = $choice;
            }
        }

        // this has to be done by yourself:  array( label => value )
        $labeledValues = MyLabelService::getLabels($values);

        // create internal choice list from loaded values
        $this->choiceList = new ArrayChoiceList($labeledValues, $value);

        return $values;
    }


    public function loadChoiceList($value = null)
    {
        // is called on form view create after loadValuesForChoices of form create
        if ($this->choiceList instanceof ChoiceListInterface) {
            return $this->choiceList;
        }

        // if no values preset yet return empty list
        $this->choiceList = new ArrayChoiceList(array(), $value);

        return $this->choiceList;
    }


    public function loadChoicesForValues(array $values, $value = null)
    {
        // is called on form submit after loadValuesForChoices of form create and loadChoiceList of form view create
        $choices = array();
        foreach ($values as $key => $val) {
            // we use a DataTransformer, thus only plain values arrive as choices which can be used directly as value
            if (is_callable($value)) {
                $choices[$key] = (string)call_user_func($value, $val, $key);
            }
            else {
                $choices[$key] = $val;
            }
        }

        // this has to be done by yourself:  array( label => value )
        $labeledValues = MyLabelService::getLabels($values);

        // reset internal choice list
        $this->choiceList = new ArrayChoiceList($labeledValues, $value);

        return $choices;
    }
}
?>
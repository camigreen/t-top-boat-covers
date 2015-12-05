<?php

/**
 *
 */
namespace SimpleUPS;

/**
 * @internal
 * @since 1.0
 */
class Package extends \SimpleUPS\Model
{
    private
        /* @var Weight $weight */
        $weight;

    private
        /* @var PackageServiceOptions */
        $PackageServiceOptions;

    /**
     * Set the weight of this package
     *
     * @param Float|Weight $weight
     *
     * @return Package
     */
    public function setWeight($weight)
    {
        if (is_numeric($weight)) {
            $weightObject = new Weight();
            $weightObject->setWeight($weight);
            $weight = $weightObject;
        } else {
            if (!($weight instanceOf Weight)) {
                throw new \Exception('Weight must either be numeric or an instance of \SimpleUPS\Weight');
            }
        }

        $this->weight = $weight;
        return $this;
    }

    /**
     * Get weight of package
     * @return Weight
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the declared value of this package
     *
     * @param Float|MonetaryValue $value
     *
     * @param string|Currency Code $code
     *
     * @return Package
     */
    public function setDeclaredValue($value, $code = null)
    {
        if(is_object($this->PackageServiceOptions)) {
            $pso = $this->PackageServiceOptions;
        } else {
            $pso = new PackageServiceOptions();
        }
        $pso->setDeclaredValue($value, $code);

        $this->PackageServiceOptions = $pso;
        return $this;
    }

    /**
     * Get weight of package
     * @return Weight
     */
    public function getPackageServiceOptions()
    {
        return $this->PackageServiceOptions;
    }
}
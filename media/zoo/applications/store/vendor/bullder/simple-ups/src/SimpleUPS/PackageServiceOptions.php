<?php namespace SimpleUPS;

/**
 * The weight of a package
 * @since 1.0
 */
class PackageServiceOptions extends Model
{
    private

        $declaredValue;

    /**
     * @internal
     *
     * @param float $value
     *
     * @param string $code
     *
     * @return PackaceServiceOptions
     */
    public function setDeclaredValue($value, $code = null)
    {
        $this->declaredValue['CurrencyCode'] = (string)$code;
        $this->declaredValue['MonetaryValue'] = (float)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getDeclaredValue()
    {
        return $this->declaredValue;
    }

    /**
     * @internal
     *
     * @param \DomDocument $dom
     *
     * @return \DOMElement
     */
    public function toXml(\DomDocument $dom)
    {
        $pso = $dom->createElement('PackageServiceOptions');
        
        if($this->declaredValue != null) { 
            
            if ($this->declaredValue['CurrencyCode'] == null) {
                $this->declaredValue['CurrencyCode'] = UPS::currencyCode;
            }

            $pso->appendChild($declaredValue = $dom->createElement('InsuredValue'));
            $declaredValue->appendChild($dom->createElement('CurrencyCode', $this->declaredValue['CurrencyCode']));
            $declaredValue->appendChild($dom->createElement('MonetaryValue', $this->declaredValue['MonetaryValue']));
        }
        return $pso;
    }

    /**
     * @internal
     *
     * @param \SimpleXMLElement $xml
     *
     * @return Weight
     */
    public static function fromXml(\SimpleXMLElement $xml)
    {
        $pso = new PackageServiceOptions();
        $pso->setIsResponse();
        $pso->setDeclaredValue($xml->DeclaredValue->MonetaryValue, $xml->DeclaredValue->CurrencyCode);

        return $pso;
    }
}
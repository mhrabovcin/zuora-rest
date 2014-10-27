<?php

namespace Zuora\Exception;


class ApiException extends ResponseException {


    /**
     * Retrieve Zuora Process ID
     *
     * @return string|null
     */
    public function getProcessId()
    {
        $data = $this->getData();
        return isset($data['processId']) ? $data['processId'] : null;
    }


    /**
     * Return list of error reasons
     *
     * @return \Zuora\Object\Reason[]
     */
    public function getReasons()
    {
        $object = new \Zuora\Object\Object($this->getData());
        return $object->map('reasons', '\Zuora\Object\Reason');
    }


    /**
     * Create single line message from exception.
     *
     * @return string
     */
    public function getMessageFromResponse()
    {
        $output = '';

        if ($process_id = $this->getProcessId()) {
            $output .= 'Zuora ID: ' . $process_id;
        }

        foreach ($this->getReasons() as $reason) {
            $output .= "\n[" . $reason->getCode() . '] ' . $reason->getMessage();
        }

        return $output;
    }

} 
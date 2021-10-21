<?php

namespace Ukrposhta;

use Ukrposhta\Data\Storage;

class Group extends Api
{

    const REQUEST_URL = 'shipment-group';

    /**
     * Get shipment group by UUID
     *
     * @param string $shipmentGroupUUID
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function get(string $shipmentGroupUUID) {
        $url = $this->getUrl(function (string $url) use($shipmentGroupUUID) {
            return $url . '/' . $shipmentGroupUUID;
        });

        return $this->send($url, $params, 'GET');
    }

    /**
     * Get all shipments by clientUUID
     *
     * @param string $clientUUID
     * @param Storage|null $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getShipmentGroupByClient(string $clientUUID, Storage $params = null) {
        $url = $this->getUrl(function (string $url) use($clientUUID) {
            return $url . '/clients/' . $clientUUID;
        });

        return $this->send($url, $params, 'GET');
    }

    /**
     * Get shipments by shipment group
     *
     * @param string $shipmentGroupUUID
     * @param Storage|null $params
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getShipments(string $shipmentGroupUUID, Storage $params = null) {
        $url = $this->getUrl(function (string $url) use($shipmentGroupUUID) {
            return $url . '/' . $shipmentGroupUUID . '/shipments';
        });

        return $this->send($url, $params, 'GET');
    }

    /**
     * Multiple add shipments to the shipments group
     *
     * @param array $shipmentsBarcode
     * @param string $shipmentGroupUUID
     * @param Storage|null $params
     */
    public function addShipmentsToShipmentGroup(array $shipmentsBarcode, string $shipmentGroupUUID, Storage $params = null) {
        $params = $params ? $params : new Storage();
        $params->addData($shipmentsBarcode);

        $url = $this->getUrl(function (string $url) use($shipmentGroupUUID) {
            return $url . '/' . $shipmentGroupUUID . '/shipments';
        });

        return $this->send($url, $params, 'PUT');
    }

    /**
     * Save and update shipments Group
     *
     * @param string $groupName
     * @param string $clientUUID
     * @param string|null $shipmentGroupUUID
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function save(string $groupName, string $clientUUID, string $shipmentGroupUUID = null) {

        $params = new Storage([
            'name' => $groupName,
            'clientUuid' => $clientUUID
        ]);

        $url = $this->getUrl(function (string $url) use ($shipmentGroupUUID) {
            if ($shipmentGroupUUID !== null) {
                $url .= '/' . $shipmentGroupUUID;
            }

            return $url;
        });

        $method = $shipmentGroupUUID ? 'POT' : 'POST';

        return $this->send($url, $params, $method);
    }
}
import _ from 'lodash';

class LabAddMicroservice {
    add(microServiceList, id, x, y) {
        if(!this._getMicroService(microServiceList, id)){
            this._addMicroServiceConfig(microServiceList, id, x, y);
        }
    }

    _getMicroService(microServiceList, uuid) {
        return _.find(microServiceList, ms => ms && ms.id && ms.id === uuid);
    }

    _addMicroServiceConfig(microServiceList, uuid, x, y) {
        microServiceList.push({id: uuid, x: x, y: y,})
    }
}
export default (microserviceList, id, x, y) => {
    return LabAddMicroservice.prototype.add(microserviceList, id, x, y);
}

import axios from 'axios';
class DrawLineHandler {
    constructor(clicks, lines, points, connectedMicroServices) {
        this.clicks = clicks;
        this.lines = lines;
        this.points = points;
        this.connectedMicroServices = connectedMicroServices;
    }

    startLineDraw(microService) {
        ++this.clicks;
        this._appendPoint(microService);
        this._appendMicroService(microService);

        if((this.clicks % 2) === 0){
            this._createLine();
            this._saveConnection();

            this._clearPoints();
            this._clearConnection();
            this.clicks = this.clicks % 2;
        }
    }

    _saveConnection () {
        axios.get(`http://${this.$BASE_HOST}/api/connect/${this.connectedMicroServices[0]}/${this.connectedMicroServices[1]}`)
            .then(x => {
                console.log(x.data);
            })
            .catch(x => {
                console.log(x.data);
            });
    }

    _createLine () {
        this.lines.push(this.points);
    }

    _clearPoints () {
        this.points = [];
    }

    _clearConnection () {
        this.connectedMicroServices = [];
    }

    _appendMicroService (microService) {
        this.connectedMicroServices.push(microService.id);
    }

    _appendPoint (microService) {
        this.points.push(microService.x);
        this.points.push(microService.y);
    }
}

export default (clicks, lines, points, connectedMicroServices) => {
    return new DrawLineHandler(clicks, lines, points, connectedMicroServices)
}

window.editarTraslado = function () {
    return {
        abierto: false,
        formData: {
            id: null,
            animal_id: '',
            origen: '',
            destino: '',
            fecha: '',
            responsable_id: ''
        },
        abrirModal(data) {
            this.formData = {
                ...data,
                animal_id: String(data.animal),
                origen: data.origen || '',
                destino: data.destino || '',
                fecha: this.formatearFecha(data.fecha),
                responsable_id: String(data.responsable_id)
            };
            this.abierto = true;
        },
        cerrarModal() {
            this.abierto = false;
        },
        formatearFecha(fechaCompleta) {
            return fechaCompleta?.split(' ')[0] || '';
        }
    };
};

    window.editarCrianza = function () {
        return {
            abierto: false,
            formData: {
                id: null,
                animal_id: '',
                descripcion: '',
                fecha: '',
                responsable_id: ''
            },
            abrirModal(data) {
                this.formData = {
                    ...data,
                    animal_id: String(data.animal),
                    fecha: this.formatearFecha(data.fecha)
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

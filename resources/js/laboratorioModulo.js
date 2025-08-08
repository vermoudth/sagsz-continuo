function editarLaboratorio() {
  return {
    abierto: false,
    formData: {
      id: null,
      animal_id: '',
      diagnostico: '',
      tratamiento: '',
      fecha: '',
      responsable_id: '',
    },
    abrirModal(data) {
      this.formData = {
        ...data,
        animal_id: String(data.animal),
        diagnostico: data.diagnostico || '',
        tratamiento: data.tratamiento || '',
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
  }
}
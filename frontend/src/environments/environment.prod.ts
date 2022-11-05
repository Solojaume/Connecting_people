var dominio_base="connectingpeople.x10.mx";

export const environment = {
  production: true,
  serverSocket: 'ws://api2.'+dominio_base+':3000',
  apiBase:"https://api2."+dominio_base+"/web/",
  imagenesBase:"https://api2."+dominio_base+"/imagenes/",
  intervalo_tiempo_reescaneo_chat_match:5000
};

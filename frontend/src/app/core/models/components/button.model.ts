
/*@Input () nombre!:string;
  @Input () link!:string;
  type!:string;
  @Input () class!:any; */
export class ButtonModel {
    constructor(
        public nombre:string = " ",
        public link:string= " ",
        public type:string = " ",
        public classCss: string = " ",
     ){
        this.nombre = nombre;
        this.link = link;
        this.type = type;
        this.classCss = classCss;
    }
    isEmpty(){
      if (this.nombre==" " && this.link==" " && this.type == " " ) {
        
      }
    }
    public getNombre() : string {
      return this.nombre;
    }
}
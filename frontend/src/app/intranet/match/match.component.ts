import { Component, OnInit } from '@angular/core';
import { TokenStorageService } from 'src/app/core/shared/services/token-storage.service';

@Component({
  selector: 'app-match',
  templateUrl: './match.component.html',
  styleUrls: ['./match.component.scss']
})
export class MatchComponent implements OnInit {
  reviews=[
    {
      punt:3,max:5,comentario:'ki',puntuaciones_review:
      [
        {aspecto:'z',punt_asp:5,min:0,max:5},
        {aspecto:'y',punt_asp:2,min:0,max:5}
      ]
    },
    {
      punt:4,max:5,comentario:'ki2',puntuaciones_review:
      [
        {aspecto:'j',punt_asp:5,min:0,max:5},
        {aspecto:'h',punt_asp:2,min:0,max:5}
      ]
    }
  ]
  contUser!:number;
  usuarios=[
    {
        "id": "1",
        "timestamp_nacimiento": "2022-04-11 12:16:59",
        "nombre": "1",
        "imagenes": ["https://cdn.pixabay.com/photo/2014/12/06/19/46/girl-559307_960_720.jpg"],
        "reviews":  [
          {
            punt:3,max:5,comentario:'ki',puntuaciones_review:
            [
              {aspecto:'z',punt_asp:5,min:0,max:5},
              {aspecto:'y',punt_asp:2,min:0,max:5}
            ]
          },
          {
            punt:4,max:5,comentario:'ki2',puntuaciones_review:
            [
              {aspecto:'j',punt_asp:5,min:0,max:5},
              {aspecto:'h',punt_asp:2,min:0,max:5}
            ]
          }
        ]
    },
    {
        "id": "2",
        "nombre": "2",
        "timestamp_nacimiento": "2022-04-11 12:17:02",
        "imagenes": ["https://empresas.blogthinkbig.com/wp-content/uploads/2019/11/Imagen3-245003649.jpg?w=800"],
        "reviews": []
    },
    {
        "id": "3",
        "nombre": "3",
        "timestamp_nacimiento": "2022-04-11 12:17:04",
        "imagenes": [],
        "reviews": []
    },
    {
        "id": "4",
        "nombre": "4",
        "timestamp_nacimiento": "2022-04-11 12:17:06",
        "imagenes": [],
        "reviews": []
    },
    {
        "id": "5",
        "nombre": "5",
        "timestamp_nacimiento": "2022-04-11 12:17:10",
        "imagenes": [],
        "reviews": []
    }
  ];



  constructor(private token:TokenStorageService) { }

  ngOnInit(): void {
    this.contUser=0;
    let to=this.token.getToken();
    let us=this.token.getUser();
    console.log();
  }
 //Recive por parametro si ha sido like o no 
 //Si es like recive true si no false
  likedislike(like:boolean){
    
    console.log("ContUser:"+this.contUser);
    if (like==true) {
      console.log("like");
    } else if (like==false) {
      console.log("dislike");
    }
    if(this.usuarios.length>this.contUser+1){
      this.contUser=this.contUser+1;
    }else{
      this.contUser=0;
    }
  }
  
  like(){
    this.likedislike(true);
  }
  dislike(){
    this.likedislike(false);
  }
  
}

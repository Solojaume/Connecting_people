import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, ParamMap } from '@angular/router';

@Component({
  selector: 'app-recuperate',
  templateUrl: './recuperate.component.html',
  styleUrls: ['./recuperate.component.scss']
})
export class RecuperateComponent implements OnInit {
  token!:string;
  constructor(private activatedRoute: ActivatedRoute) { }

  ngOnInit(): void {
    this.activatedRoute.paramMap.subscribe((parametros: ParamMap)=>{
      this.token=parametros.get("token")!;
    })
  }


}

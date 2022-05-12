import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { CookieService } from 'ngx-cookie-service';
import { Subscription } from 'rxjs';
import { AuthService } from '../core/shared/services/auth.service';
import { TokenStorageService } from '../core/shared/services/token-storage.service';

@Component({
  selector: 'app-intranet',
  templateUrl: './intranet.component.html',
  styleUrls: ['./intranet.component.scss']
})
export class IntranetComponent implements OnInit {

  constructor( private token:TokenStorageService, private router:Router, private cookieService:CookieService, private apiService:AuthService) { }
  subscribe!:Subscription ;
  error:string="";

  ngOnInit(): void {
   
   
  }

  logout(){
    this.token.signOut();
    this.cookieService.delete("usuario");
    this.token.signOut();
    this.router.navigateByUrl("/");
  }
}

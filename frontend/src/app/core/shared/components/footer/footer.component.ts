import { Component, OnInit } from '@angular/core';
import { Router, RouterLinkActive } from '@angular/router';

@Component({
  selector: 'app-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {

  constructor(){}//private routerLink:RouterLinkActive) { }

  ngOnInit(): void {
    console.log("Router Link:", RouterLinkActive);
  }

}

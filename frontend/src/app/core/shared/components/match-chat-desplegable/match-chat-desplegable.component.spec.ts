import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MatchChatDesplegableComponent } from './match-chat-desplegable.component';

describe('MatchChatDesplegableComponent', () => {
  let component: MatchChatDesplegableComponent;
  let fixture: ComponentFixture<MatchChatDesplegableComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MatchChatDesplegableComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(MatchChatDesplegableComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

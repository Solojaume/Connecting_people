import { TestBed } from '@angular/core/testing';

import { WebSocketIOService } from './web-socket-io.service';

describe('WebSocketService', () => {
  let service: WebSocketIOService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WebSocketIOService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});

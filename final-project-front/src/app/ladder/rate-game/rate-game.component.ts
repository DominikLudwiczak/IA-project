import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { LadderClientService } from 'projects/api-client/src/api/ladder.service';
import { LadderGame } from '../ladder.component';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { LadderRateRequest } from 'projects/api-client/src/model/ladderRateRequest';

@Component({
  selector: 'app-rate-game',
  templateUrl: './rate-game.component.html',
  styleUrls: ['./rate-game.component.sass']
})
export class RateGameComponent {
  loading: boolean = false;
  ladder: LadderGame;
  alert: any;

  rateLadderRequest: FormGroup = new FormGroup({
    winner_id: new FormControl('', [Validators.required]),
  });

  constructor(private dialogRef: MatDialogRef<RateGameComponent>,
    @Inject(MAT_DIALOG_DATA) private data: {
      ladder: LadderGame,
    },
    private LadderClientService: LadderClientService) {
    {
        this.ladder = data.ladder;
    }
  }

  rate() {
    this.loading = true;
    this.LadderClientService.rateLadder(this.ladder.id ,this.rateLadderRequest.value as LadderRateRequest).subscribe((res: any) => {
      this.alert = {
        type: "success",
        message: res.message
      };
    }, err => {
      this.alert = {
        type: "error",
        message: err.error.message
      };
    }).add(() => {
      this.loading = false;
      this.dialogRef.close(this.alert);
    });
  }

  close() {
    this.dialogRef.close();
  }
}

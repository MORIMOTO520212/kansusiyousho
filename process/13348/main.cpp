#include<stdio.h>
#include<stdlib.h>
#include<time.h>

extern void InsertionSort(int n, int input[], int output[]);
extern void SelectionSort(int n, int data[]);
extern void BubbleSort(int n, int data[]);


int main() {
	int input[10];
	int output[10];
	int data1[10];
	int data2[10];
	int i;

	srand(time(NULL));

	printf("���f�[�^�F\n");
	for (i = 0; i < 10; i++) {
		input[i] = rand();
		printf("%d�Ԗڂ̃f�[�^�F%d\n", i + 1, input[i]);
		data1[i] = input[i];
		data2[i] = input[i];
	}
	/* �P���}���@ */
	InsertionSort(10, input, output);
	printf("�P���}���@�F\n");
	for (i = 0; i < 10; i++) {
		printf("%d�Ԗڂ̃f�[�^�F%d\n", i + 1, output[i]);
	}
	/* �P���I��@ */
	SelectionSort(10, data1);
	printf("�P���I��@�F\n");
	for (i = 0; i < 10; i++) {
		printf("%d�Ԗڂ̃f�[�^�F%d\n", i + 1, data1[i]);
	}
	/* �o�u���\�[�g */
	BubbleSort(10, data2);
	printf("\n");
	for (i = 0; i < 10; i++) {
		printf("\n", i + 1, data2[i]);
	}
	return 0;
}
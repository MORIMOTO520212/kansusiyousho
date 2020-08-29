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

	/* 乱数発生の初期化 */
	srand(time(NULL));
	/* 乱数発生 */
	printf("元データ：\n");
	for (i = 0; i < 10; i++) {
		input[i] = rand();
		printf("%d番目のデータ：%d\n", i + 1, input[i]);
		data1[i] = input[i];
		data2[i] = input[i];
	}
	/* 単純挿入法 */
	InsertionSort(10, input, output);
	printf("単純挿入法：\n");
	for (i = 0; i < 10; i++) {
		printf("%d番目のデータ：%d\n", i + 1, output[i]);
	}
	/* 単純選択法 */
	SelectionSort(10, data1);
	printf("単純選択法：\n");
	for (i = 0; i < 10; i++) {
		printf("%d番目のデータ：%d\n", i + 1, data1[i]);
	}
	/* バブルソート */
	BubbleSort(10, data2);
	printf("バブルソート：\n");
	for (i = 0; i < 10; i++) {
		printf("%d番目のデータ：%d\n", i + 1, data2[i]);
	}
	return 0;
}
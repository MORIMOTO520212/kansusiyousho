#define _CRT_SECURE_NO_WARNINGS
#include<stdio.h>


double average(double array[]) { // 平均
	double sum = 0;
	for (int i = 0; i < sizeof array; i++) {
		sum += array[i];
	}
	return sum / sizeof array;
}
double dispersion(double array[], double average) { // 分散
	double sum = 0;
	for (int i = 0; i < sizeof array; i++) {
		sum += (array[i] - average) * (array[i] - average);
	}
	return sum / sizeof array;
}
double maximum(double array[]) { // 最大
	double max = array[0];
	for (int i = 0; i < sizeof array; i++) {
		if (array[i] > max) {
			max = array[i];
		}
	}
	return max;
}
double minimum(double array[]) { // 最小
	double min = array[0];
	for (int i = 0; i < sizeof array; i++) {
		if (array[i] < min) {
			min = array[i];
		}
	}
	return min;
}

int main(void) {
	double array[10], q, result;
	for (int i = 0; i < 5; i++) {
		printf("%dつ目の値を入力してください >", i+1);
		scanf("%lf", &q);
		array[i] = q;
	}
	printf("\n");
	result = average(array);
	printf("平均値 >%lf\n", result);
	result = dispersion(array, result);
	printf("分散値 >%lf\n", result);
	result = maximum(array);
	printf("最大値 >%lf\n", result);
	result = minimum(array);
	printf("最小値 >%lf\n", result);

	return 0;
}